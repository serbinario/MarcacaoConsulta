<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class CGM extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'gen_cgm';

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
		'data_vencimento_cnh',
		'nome_complemento',
		'nome_fantasia',
		'tipo_cadastro',
		'numero_titulo',
		'numero_zona',
		'numero_sessao',
		'numero_sus',
		'numero_nis',
		'tipo_empresa',
		'escolaridade_id',
		'nacionalidade_id',
		'sexo_id',
		'endereco_id',
		'cgm_municipio_id',
		'cnh_categoria_id',
		'estado_civil_id',
		'fone',
		'idade',
		'fone2',
		'fone3',
        'post_nun_cgm_01',
        'post_nun_cgm_02',
        'post_nun_cgm_03',
        'post_nun_cgm_04',
        'post_nun_cgm_05',
        'post_nun_cgm_06'

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
		return $this->belongsTo(EnderecoCGM::class, 'endereco_id');
	}

	public function escolaridade()
	{
		return $this->belongsTo(Escolaridade::class, 'escolaridade_id');
	}

	public function nacionalidade()
	{
		return $this->belongsTo(Nacionalidade::class, 'nacionalidade_id');
	}

	public function estadoCivil()
	{
		return $this->belongsTo(EstadoCivil::class, 'estado_civil_id');
	}

	public function sexo()
	{
		return $this->belongsTo(Sexo::class, 'sexo_id');
	}

}