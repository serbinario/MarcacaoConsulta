<div class="row">
	<div class="col-md-10">
		<div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('obs', 'obs') !!}
				{!! Form::text('obs', Session::getOldInput('obs')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('posto_saude_id', 'posto_saude_id') !!}
				{!! Form::select('posto_saude_id', array(), array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('cgm_id', 'cgm_id') !!}
				{!! Form::select('cgm_id', array(), array('class' => 'form-control')) !!}
                </div>
            </div>
		</div>
	</div>
</div>