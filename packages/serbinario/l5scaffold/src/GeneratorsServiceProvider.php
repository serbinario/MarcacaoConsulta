<?php

namespace Serbinario\L5scaffold;

use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
       $this->commands([
           'Serbinario\L5scaffold\Console\Commands\CrudGeneratorCommand',
           'Serbinario\L5scaffold\Console\Commands\CrudModelCommand',
           'Serbinario\L5scaffold\Console\Commands\CrudValidatorsCommand',
           'Serbinario\L5scaffold\Console\Commands\CrudRepositoryCommand',
           'Serbinario\L5scaffold\Console\Commands\CrudServiceCommand',
           'Serbinario\L5scaffold\Console\Commands\CrudControllerCommand',
           'Serbinario\L5scaffold\Console\Commands\CrudViewCommand'

       ]);

        //
    }
}
