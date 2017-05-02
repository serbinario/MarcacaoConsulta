<?php

namespace Serbinario\L5scaffold\Console\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Console\Command;
use DB;
use Artisan;
use Serbinario\L5scaffold\CrudGeneratorService;


class CrudGeneratorCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crudSer {table-name} {--force} {--singular} {--table-name=} {--master-layout=} {--custom-controller=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create fully functional CRUD code based on a mysql table instantly';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Retorna namespace
        //dd(app()->getNamespace());
        $tablename = strtolower($this->argument('table-name'));


        //$prefix = \Config::get('database.connections.mysql.prefix');
        //$custom_table_name = $this->option('table-name');
        //$custom_controller = $this->option('custom-controller');
        //$singular = $this->option('singular');

        $tocreate = [];

        if($tablename == 'all') {
            $pretables = json_decode(json_encode(DB::select("show tables")), true);
            $tables = [];
            foreach($pretables as $p) {
                list($key) = array_keys($p);
                $tables[] = $p[$key];
            }
            $this->info("List of tables: ".implode($tables, ","));


        }else{
            $tables = [
                'modelname' => $tablename
            ];
        }

        foreach ($tables as $t) {
            if ($this->confirm("Voce gostaria de criar o CRUD  $t ? [y|N]")) {

                $modelName = $this->ask('Qual nome do Model?');

                $this->info("Criando Model: $modelName");
                $this->call('make:modelSer', ['table-name' => $tablename, '--model-name' => $modelName]);

                $this->info("Criando Validator: $modelName");
                $this->call('make:validatorSer', ['table-name' => $tablename, '--model-name' => $modelName]);

                $this->info("Criando Repository: $modelName");
                $this->call('make:repositorySer', ['table-name' => $tablename, '--model-name' => $modelName]);

                $this->info("Criando Service: $modelName");
                $this->call('make:serviceSer', ['table-name' => $tablename, '--model-name' => $modelName]);

                $this->info("Criando Contoller: $modelName");
                $this->call('make:controllerSer', ['table-name' => $tablename, '--model-name' => $modelName]);

                $this->info("Criando View: $modelName");
                $this->call('make:viewSer', ['table-name' => $tablename, '--model-name' => $modelName]);

            }
        }


    }


}
