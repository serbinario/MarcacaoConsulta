<?php

namespace Serbinario\L5scaffold\Console\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Console\Command;
use DB;
use Artisan;
use Serbinario\L5scaffold\CrudGeneratorService;
use Serbinario\L5scaffold\Generic;
use Serbinario\L5scaffold\Inflector;


class CrudRepositoryCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repositorySer {table-name} {--force} {--singular} {--model-name=} {--master-layout=} {--custom-controller=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create fully functional CRUD code based on a mysql table instantly';

    private $tableDescribes;

    private $tableFields;

    private $pathValidators = "app/Repositories";

    //Vai ignorar esse campos da tabela
    private $ignore = array('id','created_at','updated_at');

    private $buildRepository;

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


        //Seto o caminho e o nome do arquivo modelo
        Generic::setFilePath($this->getStub());

        Generic::setReplacements(['NAMESPACE' => app()->getNamespace()]);
        Generic::setReplacements(['CLASS' => Generic::ucWords($modelName)]);

        Generic::write(Generic::getContents(Generic::getReplacements()), $this->pathValidators, "Repository");

        //Seto o caminho e o nome do arquivo modeloRepositoryEloquent
        Generic::setFilePath($this->getStubRep());

        Generic::setReplacements(['NAMESPACE' => app()->getNamespace()]);
        Generic::setReplacements(['CLASS' => Generic::ucWords($modelName)]);

        Generic::write(Generic::getContents(Generic::getReplacements()), $this->pathValidators, "RepositoryEloquent");

        //Adiciona ao arquivo SeracademicoRepositoryProvider.php os repositories
        $this->SetRepository($modelName);

    }

    /*
     * Retorna o  arquivo de modelo
     */
    protected function getStub()
    {
        return __DIR__ . '/../../stubs/modelRepository.stub';
    }

    /*
     * Retorna o arquivo de modelo
     */
    protected function getStubRep()
    {
        return __DIR__ . '/../../stubs/modelRepositoryEloquent.stub';
    }

    /**
     *Adicona Providres ao arquivo SeracademicoRepositoryProvider.php
     */
    protected function SetRepository($modelName){
        $this->buildRepository .= PHP_EOL;
        $this->buildRepository .= "\t\t\$this->app->bind(\n";
        $this->buildRepository .= "\t\t\t\\Seracademico\\Repositories\\" . Inflector::singularize($modelName)  . "Repository::class,\n";
        $this->buildRepository .= "\t\t\t\\Seracademico\\Repositories\\" . Inflector::singularize($modelName) . "RepositoryEloquent::class\n";
        $this->buildRepository .= "\t\t);\n";
        $this->buildRepository .= "\t}\n";
        $this->buildRepository .= "}";
        Generic::appendToEndOfFile(base_path(). "/app/Providers/SeracademicoRepositoryProvider.php", $this->buildRepository, 6, true);
    }


}
