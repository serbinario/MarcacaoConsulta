<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class OperacoeValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'nome' =>  '' ,
			'tipo_operacao_id' =>  '' ,
			'grupo_operaco_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];

}
