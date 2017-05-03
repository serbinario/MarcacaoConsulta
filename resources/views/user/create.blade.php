@extends('menu')

@section('content')
    <div class="container">
        <section id="content">
            {{-- Mensagem de alerta quando os dados n�o atendem as regras de valida��o que foramd efinidas no servidor --}}
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
            {!! Form::open(['route'=>'serbinario.user.store', 'method' => "POST", 'enctype' => 'multipart/form-data' ]) !!}
                @include('tamplatesForms.tamplateFormUser')
            {!! Form::close() !!}
            {!! Form::close() !!}
            {{--Fim formulario--}}
        </section>
    </div>
@stop

@section('javascript')
    <script type="text/javascript" class="init">
        $(document).ready(function () {
            $("#tree-role, #tree-permission").tree();

            $('#user a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });
        });
    </script>
@stop