<div class="row">
	<div class="col-md-10">
		<div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('nome', 'nome') !!}
				{!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('tipo_operacao_id', 'tipo_operacao_id') !!}
				{!! Form::text('tipo_operacao_id', Session::getOldInput('tipo_operacao_id')  , array('class' => 'form-control')) !!}
                </div>
            </div>
		</div>
	</div>
</div>