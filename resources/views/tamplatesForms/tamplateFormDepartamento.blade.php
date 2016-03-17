<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="form-group col-md-4">
                {!! Form::label('nome', 'Nome: ') !!}
                {!! Form::text('nome', null, array('class' => 'form-control')) !!}
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                {!! Form::label('sede_id', 'Sede: ') !!}
                {!! Form::select('sede_id', $loadFields['sede'], null,  array('class' => 'form-control')) !!}
            </div>
        </div>

        {!! Form::submit('Salvar', array('class' => 'btn btn-primary')) !!}
    </div>
</div>