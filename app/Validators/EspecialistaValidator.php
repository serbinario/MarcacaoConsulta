<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class EspecialistaValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'cgm' =>  'required' ,
			'qtd_vagas' =>  '' ,

        ],

        ValidatorInterface::RULE_UPDATE => [],
   ];

}
