<?php

namespace Serbinario\L5scaffold\Console\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Console\Command;
use DB;
use Artisan;
use Serbinario\L5scaffold\CrudGeneratorService;
use Serbinario\L5scaffold\Generic;


class CrudRepositoryCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repositorySer {model-name} {--force} {--singular} {--table-name=} {--master-layout=} {--custom-controller=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create fully functional CRUD code based on a mysql table instantly';

    private $tableDescribes;

    private $tableFields;

    private $phathValidators = "app/Repositories";

    //Vai ignorar esse campos da tabela
    private $ignore = array('id','created_at','updated_at');

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

        //Passo cada tabela e retorno todos os campos
        $this->tableDescribes = $table = DB::select('DESCRIBE ' . $modelname);

        //Comcateno em tableField todos os campos da tabela
        /*$this->tableFields .= PHP_EOL;
        foreach ($this->tableDescribes as $values) {

            if (!in_array($values->Field, $this->ignore)) {

                $this->tableFields .= "\t\t\t'" . $values->Field . "'" . " => " . " '' " . "," . "\n";
            }
        }*/

        //$this->tableFields .= "\t]";


        //Gerar o arquivo ModelRepository

        //Seto o caminho e o nome do arquivo modelo
        Generic::setFilePath($this->getStub());

        Generic::setReplacements(['NAMESPACE' => app()->getNamespace()]);
        Generic::setReplacements(['CLASS' => Generic::ucWords($modelname)]);

        Generic::write(Generic::getContents(Generic::getReplacements()), $this->phathValidators, "Repository");

        //Gerar o arquivo ModelRepositoryEloquent

        //Seto o caminho e o nome do arquivo modeloRepositoryEloquent
        Generic::setFilePath($this->getStubRep());

        Generic::setReplacements(['NAMESPACE' => app()->getNamespace()]);
        Generic::setReplacements(['CLASS' => Generic::ucWords($modelname)]);

        Generic::write(Generic::getContents(Generic::getReplacements()), $this->phathValidators, "RepositoryEloquent");




    }

    protected function getStub()
    {
        return __DIR__ . '/../../stubs/modelRepository.stub';
    }

    protected function getStubRep()
    {
        return __DIR__ . '/../../stubs/modelRepositoryEloquent.stub';
    }


}
