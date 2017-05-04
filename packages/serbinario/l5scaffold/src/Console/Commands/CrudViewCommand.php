<?php

namespace Serbinario\L5scaffold\Console\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Console\Command;
use Artisan;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Serbinario\L5scaffold\CrudGeneratorService;
use Serbinario\L5scaffold\Generic;


class CrudViewCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:viewSer {table-name} {--force} {--singular} {--model-name=} {--master-layout=} {--custom-controller=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create fully functional CRUD code based on a mysql table instantly';

    private $tableDescribes;

    private $tableFields;

    //Path onde será gerado o arquivo
    private $phathviews = "resources/views";

    //Vai ignorar esse campos da tabela
    private $ignore = array('id','created_at','updated_at');

    /**
     * Html of the form heading.     *
     * @var string
     */
    protected $formHeadingHtml = '';

    protected $formBodyHtml = '';

    private $buildImput;

    /**
     * Html of Form's fields.     *
     * @var string
     */
    protected $formFieldsHtml = '';

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

        //Nome da tablela
        $tableName = strtolower($this->argument('table-name'));

        //Nome do Model
        $modelName = $this->option('model-name');

        $this->formFieldsHtml .=  "<div class=\"row\">\n";
        $this->formFieldsHtml .=  "\t" . "<div class=\"col-md-10\">\n";
        $this->formFieldsHtml .= "\t\t" . "<div class=\"row\">\n";



        $schema = \DB::getDoctrineSchemaManager();

        //Retorna todas as tabelas
        $tables = $schema->listTableColumns($tableName);

        //Varre a procura de cada fields
        foreach ($tables as $column) {
            echo ' - ' . $column->getName() . " - " . $column->getType()->getName() . "\n";

            //Pergunta qual tipo de campo
            $typeName = $this->choice('Foi encontrado o capo '
                . $column->getName(). " do tipo " . $column->getType()->getName()
                . " Escolha um tipo", ['text', 'password', 'select', 'radio', 'date', 'checkbox', 'Não Gerar'], false);

            $this->formFieldsHtml .= $this->createField($typeName, $column);

        }

        $this->formFieldsHtml .= "\n\t\t" . "</div>\n";
        $this->formFieldsHtml .=  "\t" . "</div>\n";
        $this->formFieldsHtml .= "" . "</div>";

        Generic::setNameClasseSingular($this->getPathTemplate() . "tamplateForm" . $modelName . ".blade");
        Generic::write($this->formFieldsHtml, '');
        dd($this->formFieldsHtml);


    }

    protected function createField($type, $column)
    {
       // dd($column->getType()->getName());
        switch ($type) {
            case 'text':
                return $this->createTextField($column);
                break;
            case 'password':
                return $this->createPasswordField($column);
                break;
            case 'select':
                return $this->createSelectField($column);
                break;
            case 'radio':
                return $this->createRadioField($column);
                break;
            case 'date':
                return $this->createDateField($column);
                break;
            case 'checkbox':
                return $this->createChecboxField($column);
                break;
            case 'Não Gerar':
                break;
            default: // text
                return $this->createFormField($column);
        }
    }

    private function createTextField($column)
    {
        $this->buildImput = "";
        $this->buildImput .= PHP_EOL;
        $this->buildImput .= "\t\t\t\t{!! Form::label('" .$column->getName() . "', '" .$column->getName() . "') !!}\n";
        $this->buildImput .= "\t\t\t\t" . "{!! Form::text('" .$column->getName() . "', Session::getOldInput('" .$column->getName() . "')  , array('class' => 'form-control')) !!}";
        return $this->wrapField($this->buildImput, '');

    }

    private function createPasswordField($column)
    {
        $this->buildImput = "";
        $this->buildImput .= PHP_EOL;
        $this->buildImput .= "\t\t\t\t{!! Form::label('" .$column->getName() . "', '" .$column->getName() . "') !!}\n";
        $this->buildImput .= "\t\t\t\t" . "{!! Form::password('" .$column->getName() . "', array('class' => 'form-control')) !!}";
        return $this->wrapField($this->buildImput, '');

    }

    private function createSelectField($column)
    {
        $this->buildImput = "";
        $this->buildImput .= PHP_EOL;
        $this->buildImput .= "\t\t\t\t{!! Form::label('" .$column->getName() . "', '" .$column->getName() . "') !!}\n";
        $this->buildImput .= "\t\t\t\t" . "{!! Form::select('" .$column->getName() . "', array(), array('class' => 'form-control')) !!}";
        return  $this->wrapField($this->buildImput, '');

    }

    private function createEmailField($column)
    {
    }
    private function createRadioField($column)
    {
    }

    private function createDateField($column)
    {
        $this->buildImput = "";
        $this->buildImput .= PHP_EOL;
        $this->buildImput .= "\t\t\t\t{!! Form::label('" .$column->getName() . "', '" .$column->getName() . "') !!}\n";
        $this->buildImput .= "\t\t\t\t" . "{!! Form::text('" .$column->getName() . "', Session::getOldInput('" .$column->getName() . "'), array('class' => 'form-control datepicker')) !!}";

        return  $this->wrapField($this->buildImput, '');
    }

    private function createCheckboxField($column)
    {
    }

    public function createFormField($column){

    }

    protected function wrapField($column, $field)
    {
        $buildImput = "
            <div class=\"col-md-4\">
                <div class=\"form-group\">
                    $column
                </div>
            </div>";
        return $buildImput;

    }

    protected function getStubEdit()
    {
        return __DIR__ . '/../../stubs/edit.blade.stub';
    }

    protected function getStubCreate()
    {
        return __DIR__ . '/../../stubs/create.blade.stub';
    }

    protected function getStubIndex()
    {
        return __DIR__ . '/../../stubs/index.blade.stub';
    }

    protected function getPathTemplate()
    {
        return '/resources/views/tamplatesForms/';
    }




}
