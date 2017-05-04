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
            <div class="block-header">
                <h2>Cadastro de Usuários</h2>
            </div>

            <div class="card">
                <div class="card-body card-padding">

                    <div role="tabpanel">
                        <ul class="tab-nav" role="tablist">
                            <li><a href="#user" aria-controls="user" role="tab" data-toggle="tab">Dados Gerais</a>
                            </li>
                            <li><a href="#permission" aria-controls="permission" role="tab" data-toggle="tab">Permissões</a>
                            </li>
                            <li><a href="#perfil" aria-controls="perfil" role="tab" data-toggle="tab">Perfís</a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="user">
                                <br />
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <div class="fg-line">
                                            <label class="control-label" for="nome">Nome</label>
                                            {!! Form::text('nome', Session::getOldInput('nome') , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <div class="fg-line">
                                            <label class="control-label" for="email">Email</label>
                                            {!! Form::text('email', Session::getOldInput('email') , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-2">
                                        <div class="fg-line">
                                            <label for="password">Senha</label>
                                            {!! Form::password('password', array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-2">
                                        <label for="status" class="checkbox checkbox-inline m-r-20">
                                            {!! Form::hidden('active', 0) !!}
                                            {!! Form::checkbox('active', 1, null, Array()) !!}
                                            <i class="input-helper"></i>
                                            Ativo
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="permission">
                                <br/>

                                <div id="tree-role">
                                    <ul>
                                        <li>
                                            <input type="checkbox"> Todos
                                            <ul>
                                                @if(isset($loadFields['permission']))
                                                    @foreach($loadFields['permission'] as $id => $permission)
                                                        <li><input type="checkbox" name="permission[]" value="{{ $id  }}"> {{ $permission }} </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="perfil">
                                <br/>

                                <div id="tree-permission">
                                    <ul>
                                        @if(isset($loadFields['role']))
                                            @foreach($loadFields['role'] as $id => $role)
                                                <li><input type="checkbox" name="role[]" value="{{ $id  }}"> {{ $role }} </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-sm m-t-10">Salvar</button>
                            <a class="btn btn-primary btn-sm m-t-10" href="{{ route('serbinario.user.index') }}">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>

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