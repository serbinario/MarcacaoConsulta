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
    protected $signature = 'make:crudSer {model-name} {--force} {--singular} {--table-name=} {--master-layout=} {--custom-controller=}';

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
        $modelname = strtolower($this->argument('model-name'));
        $prefix = \Config::get('database.connections.mysql.prefix');
        $custom_table_name = $this->option('table-name');
        $custom_controller = $this->option('custom-controller');
        $singular = $this->option('singular');

        $tocreate = [];

        if($modelname == 'all') {
            $pretables = json_decode(json_encode(DB::select("show tables")), true);
            $tables = [];
            foreach($pretables as $p) {
                list($key) = array_keys($p);
                $tables[] = $p[$key];
            }
            $this->info("List of tables: ".implode($tables, ","));


        }else{
            $tables = [
                'modelname' => $modelname
            ];
        }

        foreach ($tables as $t) {
            if ($this->confirm("Voce gostaria de criar o CRUD  $t ? [y|N]")) {

                $ClassName = $this->ask('Qual nome do Model?');

                $this->info("Criando Model: $ClassName");
                $this->call('make:modelSer', ['model-name' => $ClassName]);

                $this->info("Criando Validator: $ClassName");
                $this->call('make:validatorSer', ['model-name' => $ClassName]);

                $this->info("Criando Repository: $ClassName");
                $this->call('make:repositorySer', ['model-name' => $ClassName]);

                $this->info("Criando Service: $ClassName");
                $this->call('make:serviceSer', ['model-name' => $ClassName]);

                $this->info("Criando Contoller: $ClassName");
                $this->call('make:controllerSer', ['model-name' => $ClassName]);

            }
        }


    }


}
