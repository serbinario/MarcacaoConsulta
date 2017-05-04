<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class FilaValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'cgm_id' =>  '' ,
			'especialidade_id' =>  '' ,
			'data' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];

}
