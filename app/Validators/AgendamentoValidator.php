<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class AgendamentoValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'status' =>  '' ,
			'obs' =>  '' ,
			'posto_saude_id' =>  '' ,
			'calendario_id' =>  '' ,
			'cgm_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];

}
