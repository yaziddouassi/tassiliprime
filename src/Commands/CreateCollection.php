<?php

namespace Tassili\Prime\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CreateCollection extends Command
{
    protected $signature = 'make:tassili-collection';

    protected $description = 'Create tassili colection';

    public function handle(): int
    {
        $this->info('');
        $this->line('  <fg=cyan>Tassili — Collection generator</>');
        $this->info('');

        $panelList = config('tassili.panelList', ['admin']);
        $modelList = config('tassili.modelList', []);

        // 1. Panel
        $panel = $this->choice('Panel ?', $panelList, 0);

        // 2. Modèle CRUD parent (namespace)
        if (!empty($modelList)) {
            $crudModel = $this->choice('Model CRUD parent (namespace) ?', $modelList);
        } else {
            $crudModel = $this->ask('Model CRUD parent (namespace) ?');
        }

        // 3. Nom de la collection
        $collectionName = $this->ask('Collection Name? (ex: ArticleList)');
        if (empty($collectionName)) {
            $this->error('this field is required.');
            return self::FAILURE;
        }

        // 4. Modèle de la collection
        if (!empty($modelList)) {
            $model = $this->choice('Collection Model ?', $modelList);
        } else {
            $model = $this->ask('Collection Model ? (ex: Article)');
        }

        // Normalisation
        $panel          = Str::ucfirst($panel);
        $crudModel      = Str::ucfirst($crudModel);
        $collectionName = Str::ucfirst($collectionName);
        $model          = Str::ucfirst($model);

        // Dérivés
        $className     = "{$collectionName}Collection";
        $collectionKey = Str::ucfirst($collectionName);
        $paginationKey = Str::snake($collectionKey) . '_page';
        $searchKey     = Str::snake($collectionKey) . '_search';
        $namespace     = "App\\Http\\Controllers\\Tassili\\{$panel}\\Crud\\{$crudModel}\\Collections";
        $ownClass      = "\\{$namespace}\\{$className}";
        $modelFull     = "\\App\\Models\\{$model}";

        // Vérification : le CRUD parent doit déjà exister
        $crudPath = app_path("Http/Controllers/Tassili/{$panel}/Crud/{$crudModel}");
        if (!File::isDirectory($crudPath)) {
            $this->error("Le CRUD parent dont exist : app/Http/Controllers/Tassili/{$panel}/Crud/{$crudModel}");
            $this->line('You have to create Crud parent before create collection.');
            return self::FAILURE;
        }

        // Récap
        $this->info('');
        $this->line('  <fg=yellow>SUM UP</>');
        $this->table([], [
            ['Fichier',     "app/Http/Controllers/Tassili/{$panel}/Crud/{$crudModel}/Collections/{$className}.php"],
            ['Namespace',   $namespace],
            ['Classe',      $className],
            ['Modèle',      $modelFull],
            ['Collection',  $collectionKey],
            ['Pagination',  $paginationKey],
            ['Search',      $searchKey],
        ]);

        if (!$this->confirm('Confirm Creation ?', true)) {
            $this->line('Annulé.');
            return self::SUCCESS;
        }

        // Génération
        $replacements = [
            '{{ namespace }}'       => $namespace,
            '{{ class }}'           => $className,
            '{{ modelFull }}'       => $modelFull,
            '{{ collectionKey }}'   => $collectionKey,
            '{{ collectionLabel }}' => Str::plural($model),
            '{{ searchKey }}'       => $searchKey,
            '{{ paginationKey }}'   => $paginationKey,
            '{{ ownClass }}'        => $ownClass,
        ];

        $stub    = $this->getStub();
        $content = str_replace(array_keys($replacements), array_values($replacements), $stub);

        $relativePath = "Http/Controllers/Tassili/{$panel}/Crud/{$crudModel}/Collections/{$className}.php";
        $fullPath      = app_path($relativePath);

        if (File::exists($fullPath)) {
            $this->error("This File already exist : app/{$relativePath}");
            return self::FAILURE;
        }

        File::ensureDirectoryExists(dirname($fullPath));
        File::put($fullPath, $content);

        $this->info('');
        $this->info("  ✔ Collection created with success : app/{$relativePath}");
        $this->info('');

        return self::SUCCESS;
    }

    protected function getStub(): string
    {
        // 1. Stub personnalisé à la racine du projet Laravel
        $custom = base_path('stubs/tassili.collection.stub');
        if (File::exists($custom)) {
            return File::get($custom);
        }

        // 2. Stub embarqué dans le package, à côté de cette commande
        $package = __DIR__ . '/stubs/tassili.collection.stub';
        if (File::exists($package)) {
            return File::get($package);
        }

        // 3. Fallback inline — aucun fichier stub requis
        return $this->inlineStub();
    }

    protected function inlineStub(): string
    {
        return <<<'STUB'
<?php
namespace {{ namespace }};

use Illuminate\Http\Request;
use Tassili\Prime\Http\Resources\TassiliForm;
use Tassili\Prime\Fields\TextInput;
use Spatie\RouteAttributes\Attributes\Post;

class {{ class }}
{
    public TassiliForm $tassili;
    public $model = '{{ modelFull }}';

    public function __construct(TassiliForm $tassili, Request $request)
    {
        $this->tassili = $tassili;
        $this->register($request, []);
    }

    public function register(Request $request, array $options)
    {
        $this->tassili->addCollection([
            'collection'               => '{{ collectionKey }}',
            'collectionLabel'          => '{{ collectionLabel }}',
            'model'                    => $this->model,
            'fields'                   => ['name' => 'Column'],
            'queryName'                => '{{ searchKey }}',
            'pagination_page'          => '{{ paginationKey }}',
            'permissionsToDelelteByID' => [],
            'className'                => '{{ ownClass }}',
            'action'                   => 'deleteById',
            'showDelete'               => True,
            'records'                  => function() use ($request ,$options) { 
             return {{ modelFull }}::paginate(10, ['*'], '{{ paginationKey }}') ; },
        ]);

        $this->tassili->collectionFormInsert([
            'collection' => '{{ collectionKey }}',
            'className'  => '{{ ownClass }}',
            'action'     => 'create',
            'permissions'=> [],
        ])->form([
            TextInput::make('name')
        ]);

        $this->tassili->collectionBulk([
            'collection'   => '{{ collectionKey }}',
            'label'        => 'Delete',
            'icon'         => 'delete',
            'class'        => 'text-white',
            'className'    => '{{ ownClass }}',
            'action'       => 'deleteByGroup',
            'permissions'  => [],
            'confirmation' => 'Are you sure to delete records?',
            'message'      => 'Records deleted',
        ]);

        $this->tassili->collectionForm([
            'collection'  => '{{ collectionKey }}',
            'className'   => '{{ ownClass }}',
            'action'      => 'modal1',
            'permissions' => [],
            'icon'        => 'edit',
            'text'        => '',
            'class'       => 'text-white',
            'confirm'     => 'Are you sure to change record?',
        ])->form([
            TextInput::make('name')
        ]);
    }

    public function create(Request $request)
    {
        $this->tassili->checkPermissions($request);
        $request->validate(['name' => ['required']]);
        $this->tassili->record = new $this->model;
        $this->tassili->createRecord($request);
        $this->tassili->record->save();
    }

    public function deleteByGroup(Request $request)
    {
        $this->tassili->checkPermissions($request);
        $this->model::whereIn('id', $request->actionIds)->delete();
    }

    public function deleteById(Request $request)
    {
        $this->tassili->checkPermissions($request);
        $request->model::destroy($request->id);
    }

    public function modal1(Request $request)
    {
        $this->tassili->checkPermissions($request);
        $request->validate(['name' => ['required']]);
        $this->tassili->record = $this->model::find($request->id);
        if ($this->tassili->record !== null) {
            $this->tassili->updateRecord($request);
            $this->tassili->record->save();
        }
    }
}
STUB;
    }
}