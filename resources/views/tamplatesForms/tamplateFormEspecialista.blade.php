<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="form-group col-md-5">
                <label for="cgm">CGM</label>
                <select id="cgm" class="form-control" name="cgm">
                    @if(isset($model->id) && $model->getCgm != null)
                        <option value="{{ $model->getCgm->id  }}" selected="selected">{{ $model->getCgm->nome }}</option>
                    @endif
                </select>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="especialidade">Especialidade</label>
                    <select id="especialidade" class="form-control" name="especialidade">
                        @if(isset($model->id) && $model->getEspecialidade != null)
                            <option value="{{ $model->getEspecialidade->id  }}" selected="selected">{{ $model->getEspecialidade->nome }}</option>
                        @endif
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
				{!! Form::label('qtd_vagas', 'Quantidade de vagas') !!}
				{!! Form::text('qtd_vagas', Session::getOldInput('qtd_vagas')  , array('class' => 'form-control')) !!}
                </div>
            </div>
		</div>
	</div>
    <div class="col-md-2">
        {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block pull-right')) !!}
    </div>
</div>