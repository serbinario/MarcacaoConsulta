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
			'complemento' =>  '' ,
			'cep' =>  '' ,
			'bairro_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];

}
