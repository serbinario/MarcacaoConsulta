<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class FilaValidator extends LaravelValidator
{

    use TraitReplaceRulesValidator;

    protected $attributes = [

        // Fila
        'especialidade_id' =>  'Especialidade' ,
        'data' =>  'Data de cadastro' ,
        'prioridade_id' =>  'Prioridade' ,

        // CGM
        'cgm.nome' =>  'Nome' ,
        'cgm.data_nascimento' =>  'Data de nascimento' ,
        'cgm.numero_sus' =>  'Número do SUS' ,
        'cgm.numero_nis' =>  'Número do NIS' ,
        'cgm.cpf_cnpj' =>  'CPF' ,
        'cgm.rg' =>  'RG' ,
        'cgm.fone' =>  'Telefone' ,

        //Tabela endereco
        'cgm.endereco.logradouro' => 'Logradouro',
        'cgm.endereco.numero' => 'Número',
        'cgm.endereco.complemento' => 'Complemento',
        'cgm.endereco.cep' => '',
        'cgm.endereco.bairro_id' => 'Bairro',

    ];

    protected $messages = [
        'required' => ':attribute é requerido',
        'max' => ':attribute só pode ter no máximo :max caracteres',
        'serbinario_alpha_space' => ' :attribute deve conter apenas letras e espaços entre palavras',
        'numeric' => ':attribute deve conter apenas números',
        'email' => ':attribute deve seguir esse exemplo: exemplo@dominio.com',
        'digits_between' => ':attribute deve ter entre :min - :max.',
        'cpf_br' => ':attribute deve ser um número de CPF válido',
        'unique' => ':attribute já se encontra cadastrado'
    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [

            // Fila
			'especialidade_id' =>  'required' ,
			'data' =>  'required' ,
            'prioridade_id' =>  'required' ,

            // CGM
            'cgm.nome' =>  'required' ,
            'cgm.data_nascimento' =>  '' ,
            'cgm.numero_sus' =>  'required' ,
            'cgm.numero_nis' =>  '' ,
            'cgm.cpf_cnpj' =>  '' ,
            'cgm.rg' =>  '' ,
            'cgm.fone' =>  '' ,

            // endereço
            'cgm.endereco.logradouro' => 'max:200',
            'cgm.endereco.numero' => '',
            'cgm.endereco.complemento' => 'max:150',
            'cgm.endereco.cep' => '',
            'cgm.endereco.bairro_id' => '',

        ],
        ValidatorInterface::RULE_UPDATE => [

            // Fila
            'especialidade_id' =>  'required' ,
            'data' =>  'required' ,
            'prioridade_id' =>  'required' ,

            // CGM
            'cgm.nome' =>  'required' ,
            'cgm.data_nascimento' =>  '' ,
            'cgm.numero_sus' =>  'required' ,
            'cgm.numero_nis' =>  '' ,
            'cgm.cpf_cnpj' =>  '' ,
            'cgm.rg' =>  '' ,
            'cgm.fone' =>  '' ,

            // endereço
            'cgm.endereco.logradouro' => 'max:200',
            'cgm.endereco.numero' => '',
            'cgm.endereco.complemento' => 'max:150',
            'cgm.endereco.cep' => '',
            'cgm.endereco.bairro_id' => '',

        ],
   ];

}
