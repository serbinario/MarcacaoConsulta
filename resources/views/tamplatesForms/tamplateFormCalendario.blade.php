<div class="row">
	<div class="col-md-10">
		<div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('data', 'data') !!}
				{!! Form::text('data', Session::getOldInput('data'), array('class' => 'form-control datepicker')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('hora', 'hora') !!}
				{!! Form::text('hora', Session::getOldInput('hora'), array('class' => 'form-control datepicker')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('qtd_vagas', 'qtd_vagas') !!}
				{!! Form::text('qtd_vagas', Session::getOldInput('qtd_vagas')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('especialista_id', 'especialista_id') !!}
				{!! Form::select('especialista_id', array(), array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('localidade_id', 'localidade_id') !!}
				{!! Form::select('localidade_id', array(), array('class' => 'form-control')) !!}
                </div>
            </div>
		</div>
	</div>
</div>