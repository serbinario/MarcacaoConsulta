<!DOCTYPE html>
<!--[if IE 9 ]-->
<html class="ie9">
<!--[endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SerAgendamento</title>

        <!-- -->
        <link type="text/css" rel="stylesheet" href="{{ asset('/dist/css/btnLoadind.css') }}"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/animate.css/animate.min.css') }}"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/sweetalert2/dist/sweetalert2.min.css') }}"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }}"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/datatables.net-dt/css/jquery.dataTables.min.css') }}">
        <link type="text/css" rel="stylesheet" href="{{ asset('/dist/css/datetimepicker/build/jquery.datetimepicker.min.css')}}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/dist/js/krajee/css/fileinput.css')}}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/select2/dist/css/select2.css')}}"/>
        <link type="text/css" rel="stylesheet" href="{{asset('/css/zabuto_calendar.min.css')}}" />
        {{-- --}}
        {{--<link type="text/css" rel="stylesheet" href="{{ asset('/dist/bower_components/fullcalendar/dist/fullcalendar.css') }}" />--}}
        {{--<link type="text/css" rel="stylesheet" href="{{ asset('/dist/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}" />--}}
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/fullcalendar/dist/fullcalendar.css') }}" />
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }}" />

        <!-- Animação de loading em consultas ajax -->
        <link type="text/css" rel="stylesheet" href="{{ asset('/dist/css/load.css')}}"/>
        <link href="{{ asset('/lib/chosen/chosen.css') }}" rel="stylesheet">
        <link href="{{ asset('/lib/summernote/dist/summernote.css') }}" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="{{ asset('/dist/css/app_1.min.css') }}"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/dist/css/app_2.min.css') }}"  media="screen,projection"/>

        {{--CSS personalizados--}}
        <link type="text/css" rel="stylesheet" href="{{ asset('/dist/css/demo.css') }}"  media="screen,projection"/>

        @yield('css')
    </head>
    <body id="body">
    <header id="header" class="clearfix" data-ma-theme="blue">
        <ul class="h-inner">
            <li class="hi-trigger ma-trigger" data-ma-action="sidebar-open" data-ma-target="#sidebar">
                <div class="line-wrap">
                    <div class="line top"></div>
                    <div class="line center"></div>
                    <div class="line bottom"></div>
                </div>
            </li>

            <li class="hi-logo hidden-xs">
                <a href="#">SerAgendamento</a>
            </li>

            <li class="pull-right">
                <ul class="hi-menu">


                    <li class="hidden-xs ma-trigger" data-ma-action="sidebar-open" data-ma-target="#chat">
                        <a href=""><i class="him-icon zmdi zmdi-comment-alt-text"></i></a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Top Search Content -->
        <div class="h-search-wrap">
            <div class="hsw-inner">
                <i class="hsw-close zmdi zmdi-arrow-left" data-ma-action="search-close"></i>
                <input type="text">
            </div>
        </div>
    </header>


    <section id="main">

        {{--Menu Lateral--}}
        <aside id="sidebar" class="sidebar c-overflow">
            <div class="s-profile">
                <a href="#" data-ma-action="profile-menu-toggle">
                    <div class="sp-pic">
                        <img src="/dist/img/demo/profile-pics/1.jpg" alt="">
                        {{--{{dd(Auth::user())}}--}}
                        {{--{{Auth::user()->operador()->get()->first()->nome_operadores}}--}}
                    </div>

                    <div class="sp-info">
                        {{ Auth::user()->name }}
                        <i class="zmdi zmdi-caret-down"></i>
                    </div>
                </a>

                <ul class="main-menu">
                    {{--<li>
                        <a href="profile-about.html"><i class="zmdi zmdi-account"></i>Perfil</a>
                    </li>
                    <li>
                        <a href=""><i class="zmdi zmdi-input-antenna"></i> Privacy Settings</a>
                    </li>
                    <li>
                        <a href="{{ route('user.alterarSenha') }}"><i class="zmdi zmdi-settings"></i>Alterar Senha</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}"><i class="zmdi zmdi-time-restore"></i>Sair</a>
                    </li>--}}
                    <li>
                        <a href="{{ url('auth/logout') }}"><i class="zmdi zmdi-power"></i>Sair</a>
                    </li>
                </ul>
            </div>

            <ul class="main-menu">
                <li class="sub-menu">
                    <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-plus"></i>Cadastros</a>
                    <ul>
                        <li><a href="{{ route('serbinario.cgm.index') }}">CGM</a></li>
                        <li><a href="{{ route('serbinario.fila.index') }}">Fila de Espera</a></li>
                        <li><a href="{{ route('serbinario.localidade.index') }}">Unidade de Atendimento</a></li>
                        <li><a href="{{ route('serbinario.ps.index') }}">PSF</a></li>
                        <li><a href="{{ route('serbinario.operacao.index') }}">Operações</a></li>
                        <li><a href="{{ route('serbinario.especialidade.index') }}">Especialidades</a></li>
                        <li><a href="{{ route('serbinario.especialista.index') }}">Especialistas</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-calendar"></i>Agendamento</a>
                    <ul>
                        <li><a href="{{ route('serbinario.agendamento.index') }}">Agenda</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-calendar"></i>Ralatório</a>
                    <ul>
                        <li><a href="{{ route('serbinario.relatorio.byAgenda') }}">Por Agenda</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-shield-security"></i>Administrador</a>
                    <ul>
                        <li><a href="{{ route('serbinario.user.index') }}">Cadastrar Usuário</a></li>
                    </ul>
                </li>
            </ul>
        </aside>
        {{--FIM Menu Lateral--}}

        @yield('content')

    </section>

    <!-- Page Loader -->
    <div class="page-loader">
        <div class="preloader pls-blue">
            <svg class="pl-circular" viewBox="25 25 50 50">
                <circle class="plc-path" cx="50" cy="50" r="20" />
            </svg>

            <p>Please wait...</p>
        </div>
    </div>

    <!-- Imagem de carregamento em requisições ajax-->
    <div class="modal">
        <div class="preloader pl-xxl">
            <svg class="pl-circular" viewBox="25 25 50 50">
                <circle class="plc-path" cx="50" cy="50" r="20"/>
            </svg>
        </div>
    </div>
    <!-- Fim imagem de carregamento em requisições ajax-->

    <footer id="footer" class="p-t-0">
        <strong>Copyright &copy; 2015-2016 <a target="_blank" href="http://serbinario.com.br"><i></i>SERBINARIO</a> .</strong> Todos os direitos reservados.
    </footer>

    <!-- Javascript Libraries -->
    <script src="{{ asset('/lib/jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('/lib/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/lib/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('/lib/Waves/dist/waves.min.js') }}"></script>
    <script src="{{ asset('/dist/jquery.datetimepicker.js') }}"></script>
    <script src="{{ asset('/lib/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/lib/jquery-validation/dist/jquery.validate.js') }}"></script>
    <script src="{{ asset('/lib/jquery-validation/src/additional/cpfBR.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/dist/js/adicional/unique.js')  }}"></script>
    <script src="{{ asset('/dist/js/fileinput/fileinput.min.js')}}"></script>
    <script src="{{ asset('/dist/js/krajee/js/fileinput.js')}}"></script>
    <script src="{{ asset('/dist/js/krajee/js/locales/pt-BR.js')}}"></script>
    <script src="{{ asset('/lib/jquery-mask-plugin/dist/jquery.mask.js') }}"></script>
    <script src="{{ asset('/lib/select2/dist/js/select2.full.js') }}"></script>
    <script src="{{ asset('/js/bootstrapvalidator.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('/js/zabuto_calendar.min.js')}}"></script>

    {{-- SÓ REMOVER SE NÃO EXISTIREM ERROS --}}
    {{--<script type="text/javascript" src="{{asset('/dist/bower_components/fullcalendar/dist/locale/pt-br.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/dist/bower_components/moment/min/moment.min.js')}}" ></script>
    <script type="text/javascript" src="{{asset('/dist/bower_components/fullcalendar/dist/fullcalendar.js')}}"></script>--}}
    <script type="text/javascript" src="{{ asset('/lib/moment/min/moment.min.js')}}" ></script>
    <script type="text/javascript" src="{{asset('/lib/fullcalendar/dist/fullcalendar.js')}}"></script>
    <script type="text/javascript" src="{{asset('/lib/fullcalendar/dist/locale/pt-br.js')}}"></script>

    <!-- Placeholder for IE9 -->
    <!--[if IE 9 ]-->
    <script type="text/javascript" src={{ asset('/lib/jquery-placeholder/jquery.placeholder.min.js') }}></script>
    <!--[endif]-->

    <script type="text/javascript" src={{ asset('/dist/js/app.js') }}></script>

    <script src="{{ asset('/lib/chosen/chosen.jquery.js') }}"></script>
    <script src="{{ asset('/js/jasny-bootstrap.js')}}"></script>
    <script src="{{ asset('/js/jquery.mask.js')}}"></script>
    <script src="{{ asset('/js/mascaras.js')}}"></script>
    <script src="{{ asset('/js/laroute.js')}}"></script>

    <script type="text/javascript">
        $(".chosen").chosen();
        $('.dateTimePicker').datetimepicker({
            format : 'd/m/Y'
        });
    </script>

    @yield('javascript')

    </body>
</html>