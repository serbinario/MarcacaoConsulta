<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class CalendarioValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'data' =>  '' ,
			'hora' =>  '' ,
			'status' =>  '' ,
			'qtd_vagas' =>  '' ,
			'especialista_id' =>  '' ,
			'localidade_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];

}
