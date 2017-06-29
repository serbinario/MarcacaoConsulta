<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class SubOperacaoValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'nome' =>  '' ,
			'operacao_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            'nome' =>  '' ,
            'operacao_id' =>  '' ,
        ],
   ];

}
