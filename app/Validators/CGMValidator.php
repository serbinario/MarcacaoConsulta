<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class CGMValidator extends LaravelValidator
{
	use TraitReplaceRulesValidator;

	protected $attributes = [

		'cpf_cnpj' =>  'CPF' ,
		'rg' =>  'RG' ,
		'nome' =>  'Nome' ,
		'naturalidade' =>  '' ,
		'data_nascimento' =>  'Data de nascimento' ,
		'data_falecimento' =>  '' ,
		'email' =>  '' ,
		'num_cnh' =>  '' ,
		'venci_cnh' =>  '' ,
		'numero_titulo' =>  '' ,
		'numero_zona' =>  '' ,
		'numero_sessao' =>  '' ,
		'numero_sus' =>  'N�mero do SUS' ,
		'numero_nis' =>  'N�mero do NIS' ,
		'escolaridade_id' =>  '' ,
		'nacionalidade_id' =>  '' ,
		'sexo_id' =>  'Sexo' ,
		'endereco_id' =>  '' ,
		'cgm_municipio_id' =>  'Cidad�o do munic�pio' ,
		'cnh_categoria_id' =>  '' ,
		'estado_civil_id' =>  'Estado c�vil' ,
		'fone' =>  'required' ,

		//Tabela endereco
		'endereco.logradouro' => 'Logradouro',
		'endereco.numero' => 'N�mero',
		'endereco.complemento' => 'Complemento',
		'endereco.cep' => '',
		'endereco.bairro_id' => 'Bairro',

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

			'num_cgm' =>  '' ,
			'data_cadastramento' =>  '' ,
			'cpf_cnpj' =>  '' ,
			'rg' =>  '' ,
			'orgao_emissor' =>  '' ,
			'data_expedicao' =>  '' ,
			'nome' =>  'required' ,
			'pai' =>  '' ,
			'mae' =>  '' ,
			'naturalidade' =>  '' ,
			'data_nascimento' =>  '' ,
			'data_falecimento' =>  '' ,
			'email' =>  '' ,
			'num_cnh' =>  '' ,
			'venci_cnh' =>  '' ,
			'numero_titulo' =>  '' ,
			'numero_zona' =>  '' ,
			'numero_sessao' =>  '' ,
			'numero_sus' =>  'required' ,
			'numero_nis' =>  '' ,
			'escolaridade_id' =>  '' ,
			'nacionalidade_id' =>  '' ,
			'sexo_id' =>  '' ,
			'endereco_id' =>  '' ,
			'cgm_municipio_id' =>  '' ,
			'cnh_categoria_id' =>  '' ,
			'estado_civil_id' =>  '' ,
			'fone' =>  '' ,

			//Tabela endereco
			'endereco.logradouro' => 'max:200',
			'endereco.numero' => '',
			'endereco.complemento' => 'max:150',
			'endereco.cep' => '',
			'endereco.bairro_id' => '',

        ],

        ValidatorInterface::RULE_UPDATE => [

			'num_cgm' =>  '' ,
			'data_cadastramento' =>  '' ,
			'cpf_cnpj' =>  '' ,
			'rg' =>  '' ,
			'orgao_emissor' =>  '' ,
			'data_expedicao' =>  '' ,
			'nome' =>  'required' ,
			'pai' =>  '' ,
			'mae' =>  '' ,
			'naturalidade' =>  '' ,
			'data_nascimento' =>  '' ,
			'data_falecimento' =>  '' ,
			'email' =>  '' ,
			'num_cnh' =>  '' ,
			'venci_cnh' =>  '' ,
			'numero_titulo' =>  '' ,
			'numero_zona' =>  '' ,
			'numero_sessao' =>  '' ,
			'numero_sus' =>  'required' ,
			'numero_nis' =>  '' ,
			'escolaridade_id' =>  '' ,
			'nacionalidade_id' =>  '' ,
			'sexo_id' =>  '' ,
			'endereco_id' =>  '' ,
			'cgm_municipio_id' =>  '' ,
			'cnh_categoria_id' =>  '' ,
			'estado_civil_id' =>  '' ,
			'fone' =>  '' ,

			//Tabela endereco
			'endereco.logradouro' => 'max:200',
			'endereco.numero' => '',
			'endereco.complemento' => 'max:150',
			'endereco.cep' => '',
			'endereco.bairro_id' => '',

		],
   ];

}
