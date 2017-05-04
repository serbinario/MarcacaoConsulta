@extends('menu')
{{--@if(Session::has('message'))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <em> {!! session('message') !!}</em>
                </div>
            @endif

            @if (isset($return) && $return !=  null)
                @if($return['success'] == false && isset($return[0]['fields']) &&  $return[0]['fields'] != null)
                    <div class="alert alert-warning">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        @foreach ($return[0]['fields'] as $nome => $erro)
                            {{ $erro }}<br>
                        @endforeach
                    </div>
                @elseif($return['success'] == false)
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ $return['message'] }}<br>
                    </div>
                @elseif($return['success'] == true)
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ $return['message'] }}<br>
                    </div>
                @endif
            @endif--}}
@section('content')
    <div class="container">
        <section id="content">
            {{-- Mensagem de alerta quando os dados não atendem as regras de validação que foramd efinidas no servidor --}}
            <div class="ibox-content">
                @if(Session::has('message'))
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <em> {!! session('message') !!}</em>
                    </div>
                @endif

                @if(Session::has('errors'))
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
            </div>
            {{-- Fim mensagem de alerta --}}
            {{--Formulario--}}
            {!! Form::model($model, ['route'=> ['serbinario.ps.update', $model->id], 'id' => 'formPS']) !!}
                @include('tamplatesForms.tamplateFormPostoSaude')
            {!! Form::close() !!}
            {{--Fim formulario--}}
        </section>
    </div>
@stop
@section('javascript')
    <script src="{{ asset('/js/validacoes/validation_form_psf.js')}}"></script>
@stop
