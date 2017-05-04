<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

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
		'fone',
		'idade',
		'fone2',
		'fone3',

	];


	/**
	 * @return string
	 */
	public function getDataNascimentoAttribute()
	{
		return SerbinarioDateFormat::toBrazil($this->attributes['data_nascimento']);
	}

	/**
	 *
	 * @return \DateTime
	 */
	public function setDataNascimentoAttribute($value)
	{
		$this->attributes['data_nascimento'] = SerbinarioDateFormat::toUsa($value);
	}

	/**
	 * @return string
	 */
	public function getDataFalecimentoAttribute()
	{
		return SerbinarioDateFormat::toBrazil($this->attributes['data_falecimento']);
	}

	/**
	 *
	 * @return \DateTime
	 */
	public function setDataFalecimentoAttribute($value)
	{
		$this->attributes['data_falecimento'] = SerbinarioDateFormat::toUsa($value);
	}

	/**
	 * @return string
	 */
	public function getDataExpedicaoAttribute()
	{
		return SerbinarioDateFormat::toBrazil($this->attributes['data_expedicao']);
	}

	/**
	 *
	 * @return \DateTime
	 */
	public function setDataExpedicaoAttribute($value)
	{
		$this->attributes['data_expedicao'] = SerbinarioDateFormat::toUsa($value);
	}

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