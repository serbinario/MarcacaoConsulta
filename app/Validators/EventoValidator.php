<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class EventoValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'title' =>  '' ,
			'start' =>  '' ,
			'end' =>  '' ,
			'agendamento_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];

}
