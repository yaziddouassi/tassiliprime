<?php

namespace Tassili\Prime;

use Illuminate\Support\ServiceProvider;

class TassiliServiceProvider extends ServiceProvider
{
   
    public function register(): void
    {
       $this->publishes([
            __DIR__.'/../config/tassili.php' => config_path('tassili.php'),
        ], 'tassili-config');

        $this->mergeConfigFrom(
            __DIR__.'/../config/tassili.php', 'tassili'
        );
    }

   
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        
           $this->commands([
            \Tassili\Prime\Commands\PanelCreator::class,
            \Tassili\Prime\Commands\TassiliCreator::class,
            \Tassili\Prime\Commands\CreateUser::class,
            \Tassili\Prime\Commands\CrudCommand::class,
            \Tassili\Prime\Commands\WizardCommand::class,
            \Tassili\Prime\Commands\CreateCollection::class,
            \Tassili\Prime\Commands\CreateForm::class,
        ]);
    }
}