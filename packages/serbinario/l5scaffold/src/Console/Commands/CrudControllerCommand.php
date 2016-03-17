<?php

namespace Serbinario\L5scaffold\Console\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Console\Command;
use DB;
use Artisan;
use Serbinario\L5scaffold\CrudGeneratorService;
use Serbinario\L5scaffold\Generic;


class CrudControllerCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:controllerSer {table-name} {--force} {--singular} {--model-name=} {--master-layout=} {--custom-controller=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create fully functional CRUD code based on a mysql table instantly';

    private $tableDescribes;

    private $tableFields;

    private $phathValidators = "app/Http/Controllers";


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
        $tableName = strtolower($this->argument('table-name'));

        $modelName = $this->option('model-name');

        //Passo cada tabela e retorno todos os campos
        //$this->tableDescribes = $table = DB::select('DESCRIBE ' . $tableName);



        //Seto o caminho e o nome do arquivo modelo
        Generic::setFilePath($this->getStub());
        Generic::setReplacements(['NAMESPACE' => app()->getNamespace()]);
        Generic::setReplacements(['CLASS' => Generic::ucWords($modelName)]);
        Generic::setReplacements(['MODELOBJ' => strtolower($modelName)]);
        Generic::setReplacements(['TABLE' => $tableName]);

        Generic::write(Generic::getContents(Generic::getReplacements()), $this->phathValidators, "Controller");


    }

    protected function getStub()
    {
        return __DIR__ . '/../../stubs/modelController.stub';
    }


}
