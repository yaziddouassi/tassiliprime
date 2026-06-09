<?php

namespace Tassili\Prime\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Tassili\Prime\Utils\TransformString;
use Tassili\Prime\Utils\CrudPart;

class CrudCommand extends Command
{
    protected $signature = 'make:crud';
    protected $description = 'Create Crud (v2)';

    public function handle()
    {
        // ── 1. Choisir le panel ───────────────────────────────────────────
        $panelList = config('tassili.panelList', []);
        if (empty($panelList)) {
            $this->error("No panel in config('tassili.panelList').");
            return 1;
        }
        $panel = $this->choice('Choose a panel ?', $panelList, 0);
        $this->info("You chose panel : $panel");

        // ── 2. Choisir le model ───────────────────────────────────────────
        $modelList = config('tassili.modelList', []);
        if (empty($modelList)) {
            $this->error("No model in config('tassili.modelList').");
            return 1;
        }
        $model = $this->choice('Choose a model ?', $modelList, 0);
        $this->info("You chose model : $model");

        // ── 3. Calcul des variables ───────────────────────────────────────
        $transform   = new TransformString();
        $modelLabel  = $transform->transformLink($model);   // ex: "Posts"
        $modelUrl    = $transform->transformUrl($model);    // ex: "posts"
        $panelCamel  = ucfirst($panel);                     // ex: "Admin"

        // ── 4. Vérification que le panel existe ───────────────────────────
        $panelDir = base_path("app/Http/Controllers/Tassili/{$panelCamel}");
        if (!File::exists($panelDir)) {
            $this->error("❌ This panel doesn't exist.");
            return 1;
        }

        // ── 5. Vérification que le CRUD n'existe pas déjà ─────────────────
        $crudDir = base_path("app/Http/Controllers/Tassili/{$panelCamel}/Crud/{$model}");
        if (File::exists($crudDir)) {
            $this->error("❌ CRUD already exists.");
            return 1;
        }

        // ── 6. Création des dossiers ──────────────────────────────────────
        $dirs = [
            $crudDir,
            "{$crudDir}/Customs",
            "{$crudDir}/Forms",
            "{$crudDir}/Listings/Filters",
            "{$crudDir}/Listings/Bulks",
            "{$crudDir}/Listings/ModalForms",
        ];
        foreach ($dirs as $dir) {
            File::makeDirectory($dir, 0755, true);
        }

        // ── 7. Génération des fichiers ────────────────────────────────────
        $crudPart = new CrudPart();

        // Controllers principaux
        File::put("{$crudDir}/CreatorController.php",
            $crudPart->getCreatorController($model, $modelLabel, $modelUrl, $panel, $panelCamel));

        File::put("{$crudDir}/UpdatorController.php",
            $crudPart->getUpdatorController($model, $modelLabel, $modelUrl, $panel, $panelCamel));

        File::put("{$crudDir}/ListingController.php",
            $crudPart->getListingController($model, $modelLabel, $modelUrl, $panel, $panelCamel));

        // Custom
        File::put("{$crudDir}/Customs/Custom1Controller.php",
            $crudPart->getCustom1Controller($model, $modelLabel, $modelUrl, $panel, $panelCamel));

        // Forms
        File::put("{$crudDir}/Forms/{$model}CreatorForm.php",
            $crudPart->getCreatorForm($model, $modelLabel, $modelUrl, $panel, $panelCamel));

        File::put("{$crudDir}/Forms/{$model}UpdatorForm.php",
            $crudPart->getUpdatorForm($model, $modelLabel, $modelUrl, $panel, $panelCamel));

        // Listings
        File::put("{$crudDir}/Listings/Filters/Filter.php",
            $crudPart->getListingFilter($model, $modelLabel, $modelUrl, $panel, $panelCamel));

        File::put("{$crudDir}/Listings/Bulks/Bulk.php",
            $crudPart->getListingBulk($model, $modelLabel, $modelUrl, $panel, $panelCamel));

        File::put("{$crudDir}/Listings/ModalForms/Modal.php",
            $crudPart->getListingModal($model, $modelLabel, $modelUrl, $panel, $panelCamel));

        // ── 8. Enregistrement en base ─────────────────────────────────────
        $crud = new \Tassili\Prime\Models\TassiliCrud();
        $crud->panel  = $panel;
        $crud->model  = $model;
        $crud->label  = $modelLabel;
        $crud->route  = '/' . $panel . '/' . $modelUrl;
        $crud->icon   = 'description';
        $crud->active = true;
        $crud->save();

        // ── 9. Copie des fichiers Vue ─────────────────────────────────────
        $vueTarget = base_path("resources/js/Pages/TassiliPages/{$panelCamel}/Crud/{$model}");
        File::copyDirectory(base_path('vendor/tassili/prime/Fichiers/CrudFiles'), $vueTarget);

        foreach (File::allFiles($vueTarget) as $file) {
            if ($file->getExtension() === 'txt') {
                File::move(
                    $file->getPathname(),
                    $file->getPath() . '/' . str_replace('.txt', '.vue', $file->getFilename())
                );
            }
        }

        $this->info("✅ CRUD {$model} created successfully !");
        $this->table(
            ['Type', 'File'],
            [
                ['Controller', "Crud/{$model}/CreatorController.php"],
                ['Controller', "Crud/{$model}/UpdatorController.php"],
                ['Controller', "Crud/{$model}/ListingController.php"],
                ['Controller', "Crud/{$model}/Customs/Custom1Controller.php"],
                ['Form',       "Crud/{$model}/Forms/{$model}CreatorForm.php"],
                ['Form',       "Crud/{$model}/Forms/{$model}UpdatorForm.php"],
                ['Listing',    "Crud/{$model}/Listings/Filters/Filter.php"],
                ['Listing',    "Crud/{$model}/Listings/Bulks/Bulk.php"],
                ['Listing',    "Crud/{$model}/Listings/ModalForms/Modal.php"],
                ['Vue',        "TassiliPages/{$panelCamel}/Crud/{$model}/*.vue"],
            ]
        );

        return 0;
    }
}