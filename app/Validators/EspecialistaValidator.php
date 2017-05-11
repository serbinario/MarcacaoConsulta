<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class EspecialistaValidator extends LaravelValidator
{

    use TraitReplaceRulesValidator;

    protected $attributes = [

        'cgm' =>  'Cidadão' ,
        'qtd_vagas' =>  'Quantidade de vagas' ,
        'crm' =>  'CRM' ,

    ];

    protected $messages = [
        'required' => ':attribute é requerido',
        'max' => ':attribute só pode ter no máximo :max caracteres',
        'serbinario_alpha_space' => ':attribute deve conter apenas letras e espaços entre palavras',
        'numeric' => ':attribute deve conter apenas números',
        'email' => ':attribute deve seguir esse exemplo: exemplo@dominio.com',
        'digits_between' => ':attribute deve ter entre :min - :max.',
        'cpf_br' => ':attribute deve ser um número de CPF válido',
        'unique' => ':attribute já se encontra cadastrado'
    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'cgm' =>  'required' ,
            'qtd_vagas' =>  'required' ,
            'crm' =>  'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'cgm' =>  'required' ,
            'qtd_vagas' =>  'required' ,
            'crm' =>  'required'
        ],
    ];

}
