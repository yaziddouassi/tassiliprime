<?php

namespace Tassili\Prime\Utils;

use Illuminate\Support\Str;

class CrudPart
{
    // ══════════════════════════════════════════════════════════════════════
    // CONTROLLERS PRINCIPAUX
    // ══════════════════════════════════════════════════════════════════════

    public function getCreatorController($a, $b, $c, $panel, $panelCamel): string
    {
        return "<?php

namespace App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Tassili\Prime\Http\Resources\TassiliForm;
use Tassili\Prime\Fields\TextInput;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a}\Forms\\{$a}CreatorForm;

class CreatorController extends Controller
{
    private TassiliForm \$tassili;
    private array \$pageSettings = [];
    private string \$modelClass = 'App\Models\\{$a}';
    private string \$tassiliPanel = '{$panel}';

    public function __construct()
    {
        \$this->tassili = new TassiliForm([
            'tassiliPanel' => \$this->tassiliPanel,
        ]);
        \$this->pageSettings = [
            'modelClass'     => \$this->modelClass,
            'modelClassName' => '{$a}',
            'modelLabel'     => '{$b}',
            'modelTitle'     => 'Create {$b}',
            'routeListe'     => '/{$panel}/{$c}',
            'urlCreate'      => '/{$panel}/{$c}/create',
            'className'      => '\App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a}\Forms\\{$a}CreatorForm',
            'action'         => 'create',
        ];
    }

    public function initTassili(Request \$request): void
    {
        new {$a}CreatorForm(\$this->tassili, \$request);
    }

    #[Get('{$panel}/{$c}/create', middleware: ['tassili.auth'])]
    public function index(Request \$request)
    {
        \$this->initTassili(\$request);

        return Inertia::render('TassiliPages/{$panelCamel}/Crud/{$a}/Creator', [
            'tassiliSettings' => \$this->tassili->getInertiaData(),
            'pageSettings'    => \$this->pageSettings,
        ]);
    }
}
";
    }

    // ──────────────────────────────────────────────────────────────────────

    public function getUpdatorController($a, $b, $c, $panel, $panelCamel): string
    {
        return "<?php

namespace App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Tassili\Prime\Http\Resources\TassiliForm;
use Tassili\Prime\Fields\TextInput;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a}\Forms\\{$a}UpdatorForm;

class UpdatorController extends Controller
{
    private TassiliForm \$tassili;
    private array \$pageSettings = [];
    private string \$modelClass = 'App\Models\\{$a}';
    private string \$tassiliPanel = '{$panel}';

    public function __construct()
    {
        \$this->tassili = new TassiliForm([
            'tassiliPanel' => \$this->tassiliPanel,
        ]);
        \$this->pageSettings = [
            'modelClass'     => \$this->modelClass,
            'modelClassName' => '{$a}',
            'modelLabel'     => '{$b}',
            'modelTitle'     => 'Update {$b}',
            'routeListe'     => '/{$panel}/{$c}',
            'urlCreate'      => '/{$panel}/{$c}/create',
            'className'      => '\App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a}\Forms\\{$a}UpdatorForm',
            'action'         => 'create',
        ];
    }

    public function initTassili(Request \$request): void
    {
        new {$a}UpdatorForm(\$this->tassili, \$request);
    }

    #[Get('{$panel}/{$c}/update/{id}', middleware: ['tassili.auth'])]
    public function index(Request \$request)
    {
        \$record = \$this->modelClass::findOrFail(\$request->id);
        \$this->initTassili(\$request);

        return Inertia::render('TassiliPages/{$panelCamel}/Crud/{$a}/Updator', [
            'tassiliSettings' => \$this->tassili->getInertiaData(),
            'pageSettings'    => \$this->pageSettings,
            'record'          => \$record,
        ]);
    }
}
";
    }

    // ──────────────────────────────────────────────────────────────────────

    public function getListingController($a, $b, $c, $panel, $panelCamel): string
    {
        return "<?php

namespace App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a};

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Tassili\Prime\Http\Resources\ListingUtility;
use Tassili\Prime\Fields\TextInput;
use Tassili\Prime\Fields\Repeater;
use Tassili\Prime\Filters\FilterText;
use App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a}\Listings\Filters\Filter;
use App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a}\Listings\Bulks\Bulk;
use App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a}\Listings\ModalForms\Modal;

class ListingController extends Controller
{
    private string \$modelClass = 'App\Models\\{$a}';
    private ListingUtility \$utility;
    private string \$tassiliPanel = '{$panel}';

    public function __construct(Request \$request)
    {
        \$this->utility = new ListingUtility([
            'tassiliPanel'           => \$this->tassiliPanel,
            'tassiliDataModelLabel'  => '{$b}',
            'tassiliDataModelTitle'  => 'Create {$b}',
            'tassiliDataRouteListe'  => '/{$panel}/{$c}',
            'tassiliDataUrlCreate'   => '/{$panel}/{$c}/create',
            'tassiliModelClass'      => \$this->modelClass,
            'tassiliModelClassName'  => '{$a}',
            'paginationPerPageList'  => [10, 20, 30, 40, 50],
            'orderByFieldList'       => ['id'],
            'orderDirectionList'     => ['asc', 'desc'],
            'urlDelete'              => '/{$panel}/{$c}/delete_by_id',
            'showDelete'             => true,
            'showEdit'               => true,
            'permissionsToDeleteById'=> [],
            'permissionsToUpdateById'=> [],
        ]);

        \$this->initTassili();
    }

    private function initTassili(): void
    {
        new Filter(\$this->utility);
        new Bulk(\$this->utility);
        new Modal(\$this->utility);
    }

    private function initQuery(\$query, Request \$request): void
    {
        if (\$request->filled('name')) {
            // \$query->where('name', \$request->name);
        }
    }

    #[Post('{$panel}/{$c}/delete_by_id', middleware: ['tassili.auth'])]
    public function deleteById(Request \$request)
    {
        \$request->model::destroy(\$request->id);
    }

    #[Get('{$panel}/{$c}', middleware: ['tassili.auth'])]
    public function index(Request \$request)
    {
        \$this->utility->initializeQuery(
            \$this->modelClass,
            \$request,
            fn(\$query, \$req) => \$this->initQuery(\$query, \$req)
        );
        \$data = \$this->utility->getInertiaData();
        \$data['sessionFilter'] = [/*'search','orderByField','orderDirection','paginationPerPage'*/];

        return Inertia::render('TassiliPages/{$panelCamel}/Crud/{$a}/Listing', [
            'tassiliSettings' => \$data,
        ]);
    }
}
";
    }

    // ──────────────────────────────────────────────────────────────────────

    public function getCustom1Controller($a, $b, $c, $panel, $panelCamel): string
    {
        return "<?php

namespace App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a}\Customs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Tassili\Prime\Http\Resources\TassiliForm;

class Custom1Controller extends Controller
{
    private TassiliForm \$tassili;
    private string \$tassiliPanel = '{$panel}';

    public function __construct()
    {
        config(['inertia.ssr.enabled' => false]); // SSR desactivated
        \$this->tassili = new TassiliForm([
            'tassiliPanel' => \$this->tassiliPanel,
        ]);
    }

    public function initTassili(\$request): void
    {
        //
    }

    #[Get('{$panel}/{$c}/customs/page1', middleware: ['tassili.auth'])]
    public function index(Request \$request)
    {
        \$this->initTassili(\$request);

        return Inertia::render('TassiliPages/{$panelCamel}/Crud/{$a}/Customs/Custom1', [
            'tassiliSettings' => \$this->tassili->getInertiaData(),
        ]);
    }
}
";
    }

    // ══════════════════════════════════════════════════════════════════════
    // FORMS
    // ══════════════════════════════════════════════════════════════════════

    public function getCreatorForm($a, $b, $c, $panel, $panelCamel): string
    {
        return "<?php

namespace App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a}\Forms;

use Illuminate\Http\Request;
use Tassili\Prime\Http\Resources\TassiliForm;
use App\Http\Controllers\Controller;
use Tassili\Prime\Fields\TextInput;
use Spatie\RouteAttributes\Attributes\Post;

class {$a}CreatorForm
{
    public TassiliForm \$tassili;
    public \$model = '\App\Models\\{$a}';

    public function __construct(TassiliForm \$tassili, Request \$request)
    {
        \$this->tassili = \$tassili;
        \$this->register(\$request, []);
    }

    //////////////////////////////////////////////////
    //////////////////////////////////////////////////
    //////////////////////////////////////////////////

    public function register(\$request, array \$options): void
    {
        \$this->tassili->addForm([
            'className'   => '\App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a}\Forms\\{$a}CreatorForm',
            'action'      => 'create',
            'permissions' => [],
        ])->form([
            TextInput::make('name'),
        ])->redirectToList('{$panel}', '{$a}');
    }

    //////////////////////////////////////////////////
    //////////////////////////////////////////////////
    //////////////////////////////////////////////////

    public function create(Request \$request)
    {
        \$request->validate(['name' => ['required']]);
        \$this->tassili->record = new \$this->model;
        \$this->tassili->createRecord(\$request);
        \$this->tassili->record->save();
    }
}
";
    }

    // ──────────────────────────────────────────────────────────────────────

    public function getUpdatorForm($a, $b, $c, $panel, $panelCamel): string
    {
        return "<?php

namespace App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a}\Forms;

use Illuminate\Http\Request;
use Tassili\Prime\Http\Resources\TassiliForm;
use App\Http\Controllers\Controller;
use Tassili\Prime\Fields\TextInput;
use Spatie\RouteAttributes\Attributes\Post;

class {$a}UpdatorForm
{
    public TassiliForm \$tassili;
    public \$model = '\App\Models\\{$a}';

    public function __construct(TassiliForm \$tassili, Request \$request)
    {
        \$this->tassili = \$tassili;
        \$this->register(\$request, []);
    }

    //////////////////////////////////////////////////
    //////////////////////////////////////////////////
    //////////////////////////////////////////////////

    public function register(\$request, array \$options): void
    {
        \$this->tassili->addForm([
            'className'   => '\App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a}\Forms\\{$a}UpdatorForm',
            'action'      => 'create',
            'permissions' => [],
        ])->form([
            TextInput::make('name'),
        ])->showUpdateAndStay()
          ->redirectToList('{$panel}', '{$a}');
    }

    //////////////////////////////////////////////////
    //////////////////////////////////////////////////
    //////////////////////////////////////////////////

    public function create(Request \$request)
    {
        \$request->validate(['name' => ['required']]);
        \$this->tassili->record = \$this->model::find(\$request->id);

        if (\$this->tassili->record !== null) {
            \$this->tassili->updateRecord(\$request);
            \$this->tassili->record->save();
        }
    }
}
";
    }

    // ══════════════════════════════════════════════════════════════════════
    // LISTINGS
    // ══════════════════════════════════════════════════════════════════════

    public function getListingFilter($a, $b, $c, $panel, $panelCamel): string
    {
        return "<?php

namespace App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a}\Listings\Filters;

use Tassili\Prime\Http\Resources\ListingUtility;
use Tassili\Prime\Filters\FilterText;

class Filter
{
    public ListingUtility \$utility;

    public function __construct(ListingUtility \$utility)
    {
        \$this->utility = \$utility;
        \$this->register();
    }

    //////////////////////////////////////////////////
    //////////////////////////////////////////////////

    public function register(): void
    {
        \$this->utility->filterList([
            FilterText::make('name'),
        ]);
    }

    //////////////////////////////////////////////////
    //////////////////////////////////////////////////
}
";
    }

    // ──────────────────────────────────────────────────────────────────────

    public function getListingBulk($a, $b, $c, $panel, $panelCamel): string
    {
        return "<?php

namespace App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a}\Listings\Bulks;

use Tassili\Prime\Http\Resources\ListingUtility;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Post;

class Bulk extends Controller
{
    public ListingUtility \$utility;
    public \$model = '\App\Models\\{$a}';

    public function __construct(ListingUtility \$utility)
    {
        \$this->utility = \$utility;
        \$this->register();
    }

    //////////////////////////////////////////////////
    //////////////////////////////////////////////////

    public function register(): void
    {
        \$this->utility->addBulk([
            'className'    => '\App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a}\Listings\Bulks\Bulk',
            'action'       => 'bulk1',
            'permissions'  => [],
            'label'        => 'Delete',
            'icon'         => 'delete',
            'class'        => 'text-white',
            'confirmation' => 'Are you sure to delete these records?',
            'message'      => 'Records deleted',
        ]);
    }

    //////////////////////////////////////////////////
    //////////////////////////////////////////////////

    public function bulk1(Request \$request)
    {
        \$this->model::whereIn('id', \$request->actionIds)->delete();
    }
}
";
    }

    // ──────────────────────────────────────────────────────────────────────

    public function getListingModal($a, $b, $c, $panel, $panelCamel): string
    {
        return "<?php

namespace App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a}\Listings\ModalForms;

use Tassili\Prime\Http\Resources\ListingUtility;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Post;
use Tassili\Prime\Fields\TextInput;

class Modal extends Controller
{
    public ListingUtility \$utility;
    public \$model = '\App\Models\\{$a}';

    public function __construct(ListingUtility \$utility)
    {
        \$this->utility = \$utility;
        \$this->register();
    }

    //////////////////////////////////////////////////
    //////////////////////////////////////////////////

    public function register(): void
    {
        \$this->utility->addModalForm([
            'className'   => '\App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$a}\Listings\ModalForms\Modal',
            'action'      => 'modal1',
            'permissions' => [],
            'icon'        => 'edit',
            'text'        => 'Qte',
            'class'       => 'text-white',
            'confirm'     => 'Are you sure to change record?',
        ])->form([
            TextInput::make('name'),
        ]);
    }

    //////////////////////////////////////////////////
    //////////////////////////////////////////////////

    public function modal1(Request \$request)
    {
        \$request->validate(['name' => ['required']]);
        \$this->utility->record = \$this->model::find(\$request->id);

        if (\$this->utility->record !== null) {
            \$this->utility->updateRecord(\$request);
            \$this->utility->record->save();
        }
    }
}
";
    }
}