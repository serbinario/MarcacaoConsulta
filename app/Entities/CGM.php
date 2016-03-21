<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class CGM extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'cgm';

    protected $fillable = [ 
		'num_cgm',
		'data_cadastramento',
		'cpf_cnpj',
		'rg',
		'orgao_emissor',
		'data_expedicao',
		'nome',
		'pai',
		'mae',
		'naturalidade',
		'data_nascimento',
		'data_falecimento',
		'email',
		'num_cnh',
		'venci_cnh',
		'nire',
		'nome_complemento',
		'nome_fantasia',
		'tipo_cadastro',
		'numero_titulo',
		'numero_zona',
		'numero_sessao',
		'numero_sus',
		'numero_nis',
		'tipo_empresa',
		'escolaridade',
		'nacionalidade',
		'sexo',
		'endereco_cgm',
		'cgmmunicipio',
		'categoria_cnh',
		'estado_civil',
	];

	public function endereco()
	{
		return $this->belongsTo(EnderecoCGM::class, 'endereco_cgm');
	}

	public function escolaridade()
	{
		return $this->belongsTo(Escolaridade::class, 'escolaridade');
	}

	public function nacionalidade()
	{
		return $this->belongsTo(Nacionalidade::class, 'nacionalidade');
	}

	public function estadoCivil()
	{
		return $this->belongsTo(EstadoCivil::class, 'estado_civil');
	}

	public function sexo()
	{
		return $this->belongsTo(Sexo::class, 'sexo');
	}

}