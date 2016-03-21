<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class EnderecoCGMValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'logradouro' =>  '' ,
			'numero' =>  '' ,
			'comp' =>  '' ,
			'cep' =>  '' ,
			'bairro' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];

}
