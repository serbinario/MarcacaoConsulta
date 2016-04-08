<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SerAcadêmico - Login</title>

    <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{ asset('/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/style.css')}}" rel="stylesheet">
   {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">--}}
</head>
<body class="gray-bg">
<div class="loginColumns animated fadeInDown">
    <div class="row">
        <div class="col-sm-4 col-md-6">

            <h2 class="text-center">Bem Vindo ao <b class="text-success">Sistema de Agendamento</b></h2>

            <p class="text-center">
                Faça login para ter acesso. Caso não esteja cadastrado, increva-se.
            </p>

        </div>
        <div class="col-sm-8 col-md-6">
            <div class="ibox-content">
                <p>
                    <img src="{{ asset('/img/logo_igarassu.png')}}" style="width: 70%;margin-left: 15%;"/>
                </p>
                {!! Form::open(['url'=>'auth/login', 'method' => "POST"]) !!}
                {!! csrf_field() !!}
                <div class="form-group">
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Usuário">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Senha">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Logar</button>

                @if(Session::has('message'))
                    <div class="alert alert-danger">
                        @lang('messages.login_and_password_invalids')<br>
                    </div>

                @endif

               {{-- <p class="text-muted text-center">
                    <small><a href="#">Esqueceu a senha?</a></small>
                </p>
                <p class="text-muted text-center">
                    <small>Não tem uma conta?</small>
                </p>
                <a class="btn btn-sm btn-white btn-block" href="register.html">Criar uma conta</a>--}}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-6">

        </div>
        <div class="col-md-6 text-right">
            <img src="{{ asset('/img/s1.png')}}" style="width: 20%;"/>
        </div>
    </div>
<script src="{{ asset('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js')}}" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>
