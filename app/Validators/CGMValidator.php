<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class CGMValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'num_cgm' =>  '' ,
			'data_cadastramento' =>  '' ,
			'cpf_cnpj' =>  'required' ,
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
			'nire' =>  '' ,
			'tipo_cadastro' =>  '' ,
			'numero_titulo' =>  '' ,
			'numero_zona' =>  '' ,
			'numero_sessao' =>  '' ,
			'numero_sus' =>  '' ,
			'numero_nis' =>  '' ,
			'escolaridade' =>  '' ,
			'nacionalidade' =>  '' ,
			'sexo' =>  '' ,
			'endereco_cgm' =>  '' ,
			'cgmmunicipio' =>  '' ,
			'categoria_cnh' =>  '' ,
			'estado_civil' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];

}
