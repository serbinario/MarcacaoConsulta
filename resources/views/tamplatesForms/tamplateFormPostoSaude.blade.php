<div class="block-header">
    <h2>Cadastrar PSF</h2>
</div>

<div class="card">
    <div class="card-body card-padding">
        {{--#1--}}
        <div class="row">
            <div class="form-group col-sm-4">
                <div class="fg-line">
                    <label class="control-label" for="nome">Nome</label>
                    {!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                </div>
            </div>
            <div class="form-group col-sm-2">
                <div class="fg-line">
                    <label class="control-label" for="cnes">CNES</label>
                    {!! Form::text('cnes', Session::getOldInput('cnes')  , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                </div>
            </div>

        </div>
        {{--#2--}}
        <div class="row">
            <div class="form-group col-sm-4">
                <div class="fg-line">
                    <label class="control-label" for="endereco">Logradouro</label>
                    {!! Form::text('endereco', Session::getOldInput('endereco')  , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                </div>
            </div>
            <div class="form-group col-sm-2">
                <div class="fg-line">
                    <label class="control-label" for="numero">Número</label>
                    {!! Form::text('numero', Session::getOldInput('numero')  , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                </div>
            </div>
            <div class="form-group col-sm-4">
                <div class=" fg-line">
                    <label for="bairro_id">Bairro</label>

                    <div class="select">
                        {!! Form::select('bairro_id', $loadFields['bairro'], null, array('class'=> 'form-control input-sm')) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-sm m-t-10">Salvar</button>
                <a class="btn btn-primary btn-sm m-t-10" href="{{ route('serbinario.ps.index') }}">Voltar</a>
            </div>
        </div>
    </div>
</div>
@section('javascript')
    <script src="{{ asset('/js/validacoes/validation_form_psf.js')}}"></script>
@stop