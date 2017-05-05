<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class PostoSaudeValidator extends LaravelValidator
{

    use TraitReplaceRulesValidator;

    protected $attributes = [

        'nome' =>  'Nome' ,

    ];

    protected $messages = [
        'required' => ':attribute � requerido',
        'max' => ':attribute s� pode ter no m�ximo :max caracteres',
        'serbinario_alpha_space' => ' :attribute deve conter apenas letras e espa�os entre palavras',
        'numeric' => ':attribute deve conter apenas n�meros',
        'email' => ':attribute deve seguir esse exemplo: exemplo@dominio.com',
        'digits_between' => ':attribute deve ter entre :min - :max.',
        'cpf_br' => ':attribute deve ser um n�mero de CPF v�lido',
        'unique' => ':attribute j� se encontra cadastrado'
    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [

            'nome' =>  'required' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            'nome' =>  'required' ,
        ],
    ];

}
