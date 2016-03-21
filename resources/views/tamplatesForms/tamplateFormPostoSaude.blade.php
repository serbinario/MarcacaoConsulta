<div class="row">
	<div class="col-md-12">
		<div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('nome', 'nome') !!}
				{!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                </div>
            </div>
		</div>
	</div>
	<div class="col-md-2">
		{!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block pull-right')) !!}
	</div>
</div>