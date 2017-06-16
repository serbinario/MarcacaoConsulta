@extends('menu')

@section('css')
    <style type="text/css" class="init">
        .modal {
            display:    none;
            position:   fixed;
            z-index:    1000;
            top:        0;
            left:       0;
            height:     100%;
            width:      100%;
            background: rgba( 255, 255, 255, .8 )
            /*url('http://i.stack.imgur.com/FhHRx.gif')*/
            50% 50%
            no-repeat;
        }

        /* enquanto estiver carregando, o scroll da página estará desativado */
        body.loading {
            overflow: hidden;
        }

        /* a partir do momento em que o body estiver com a classe loading,  o modal aparecerá */
        body.loading .modal {
            display: block;
        }

    </style>
@endsection


@section('content')
    <div class="container">
        <section id="content">
            {{-- Mensagem de alerta quando os dados não atendem as regras de validação que foramd efinidas no servidor --}}
            {{-- <div class="ibox-content">
             </div>--}}

            {{--<div class="block-header">
                <h2>Agendamento</h2>
            </div>--}}
            <div class="modal"></div>
            <div class="card">
                <div class="card-body card-padding">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="container container-alt">
                                <div class="block-header block-header-calendar">
                                    <h2>
                                        <span></span>
                                        <small>Calendário para agendamento das consultas médicas</small>
                                    </h2>

                                    <ul class="actions actions-calendar">
                                        <li><a class="calendar-next" href=""><i class="zmdi zmdi-chevron-left"></i></a></li>
                                        <li><a class="calendar-prev" href=""><i class="zmdi zmdi-chevron-right"></i></a></li>

                                        <li class="dropdown">
                                            <a href="" data-toggle="dropdown"><i class="zmdi zmdi-more-vert"></i></a>
                                            <ul class="dropdown-menu dm-icon pull-right">
                                                <li><a href="" data-calendar-view="month"><i class="zmdi zmdi-view-comfy active"></i> Visualizar por Mês</a></li>
                                                <li><a href="" data-calendar-view="basicWeek"><i class="zmdi zmdi-view-week"></i> Visualizar por Semana</a></li>
                                                <li><a href="" data-calendar-view="basicDay"><i class="zmdi zmdi-view-day"></i> Visualizar por Dia</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>

                                <div id="calendar" class="card"></div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h2>AGENDA ESPECIALISTA</h2>
                                </div>
                                <div class="card-body m-t-0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form method="post" id="form_agendamento">

                                                <div class="form-group col-md-12">
                                                    <div class="fg-line">
                                                        {!! Form::label('localidade', 'Unidade de Atendimento') !!}
                                                        {!! Form::select('localidade', ['' => 'Selecione'] + $loadFields['localidade']->toArray(), null, array('class' => 'form-control input-sm', 'id' => 'localidade')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <div class="fg-line">
                                                        {!! Form::label('localidade', 'Tipo de operação') !!}
                                                        {!! Form::select('tipo_operacao', ['' => 'Selecione'] + $loadFields['tipooperacao']->toArray(), null, array('class' => 'form-control', 'id' => 'tipo_operacao')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <div class="fg-line">
                                                        {!! Form::label('grupo_operacao', 'Especialidade') !!}
                                                        <select class="form-control" name="grupo_operacao" id="grupo_operacao">
                                                            <option>Selecione</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <div class="fg-line">
                                                        {!! Form::label('especialista', 'Especialista') !!}
                                                        <select class="form-control" name="especialista" id="especialista">
                                                            <option>Selecione</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <div class="fg-line">
                                                        <button type="button" id="btnConsultar"
                                                                class="btn btn-primary btn-sm m-t-10">Consultar
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('agendamento.modal_agendamento')
    @include('agendamento.modal_evento_agendamento')
@stop
@section('javascript')
    <script type="text/javascript" src="{{asset('/js/agendamento/selects.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/agendamento/script-agendamento.js')}}"></script>
    <script type="text/javascript">
        // Variáveis globais
        var idDoCalendario;

        $(document).ready(function () {

            var date = new Date();
            var m = date.getMonth();
            var y = date.getFullYear();
            var target = $('#calendar');

            // Campos da pesquisa zerados para carregamento inicial do calendário
            var dados = {
                'idLocalidade': "",
                'idEspecialista': ""
            };

            // Submete a pesquisa para carregamento do calendário por especialista e localidade
            $('#btnConsultar').click(function () {
                var localidade = $('#localidade').val();
                var especialista = $('#especialista').val();
                var especialidade = $('#grupo_operacao').val();

                //
                if (!localidade || !especialista || !especialidade) {
                    swal("Por favor, preencha todos os campos para consultar!");
                    return false;
                }

                dados = {
                    'idLocalidade': localidade,
                    'idEspecialista': especialista
                };

                $('#calendar').fullCalendar('refetchEvents');
                paciente("", especialidade);
            });

            // Carrega o calendário
            target.fullCalendar({
                header: {
                    right: '',
                    center: '',
                    left: ''
                },
                theme: false,
                selectable: true,
                selectHelper: true,
                editable: true,
                events: function (start, end, timezone, callback) {

                    // Adicionando o loading da requisição
                    $('body').addClass("loading");

                    // Carrega os dias do calendário médico e seus eventos (agendamentos)
                    jQuery.ajax({
                        url: '{{ route('serbinario.agendamento.loadCalendar') }}',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            start: start.format(),
                            end: end.format(),
                            data: dados
                        },
                        success: function (doc) {

                            // Removendo o loading da requisição
                            $('body').removeClass("loading");

                            var events = [];
                            if (!!doc) {
                                $.map(doc, function (r) {
                                    events.push({
                                        title: r.title,
                                        start: r.date_start,
                                        overlap: r.overlap,
                                        rendering: r.rendering,
                                        color: r.color,
                                        id: r.color,
                                        idPaciente: r.idPaciente,
                                        idAgendamento: r.idAgendamento,
                                    });
                                });
                            }
                            callback(events);
                        }
                    });


                },
                dayClick: function (date, allDay, jsEvent, view, resourceObj) {

                    var idMedico        = $('#especialista').val();
                    var idLocal         = $('#localidade').val();
                    var especialidade   = $('#grupo_operacao').val();
                    var data = date.format();

                    //Dados do para validar especialista
                    var dados = {
                        idMedico: idMedico,
                        data: data,
                        idLocalidade: idLocal
                    };

                    jQuery.ajax({
                        type: 'POST',
                        url: '{{ route('serbinario.calendario.calendariodatamedico') }}',
                        data: dados,
                        datatype: 'json'
                    }).done(function (json) {

                        if (json['retorno'] === true) {

                            // Preenchendo a variável global do calendário
                            idDoCalendario = json['calendario']['id'];

                            $('#calendario').val(json['calendario']['id']);
                            $('#data').val(json['calendario']['data']);
                            $('#obs').text('');
                            paciente("", especialidade);

                            // Limpando o html da div para cabeçalho do modal de agendamento
                            $('#modal-cabecalho').html("");

                            // Preenchendo o cabeçalho do modal de agendamento
                            for (var i = 0; i < json['mapas'].length; i++) {

                                var html = "";

                                // Pegando a quantidade de vagas restantes
                                var vagasRestantes = json['mapas'][i]['vagas'] - json['mapas'][i]['qtdAgendados'];

                                // Criando o html para cabeçalho da modal
                                html += '<b>Mapa:</b>' +json['mapas'][i]['horario'] + " / " + '<b>Total de Vagas:</b>'
                                        + json['mapas'][i]['vagas'] + ' / ';

                                // Verifica se as vagas para o primeiro mapa estão esgotados
                                if (vagasRestantes <= "0") {
                                    html += '<b>Total de Agendados: </b>' + "<span style='color: red' '>" + json['mapas'][i]['qtdAgendados'] + "</span>" + ' / ';
                                } else {
                                    html += '<b>Total de Agendados: </b>' + json['mapas'][i]['qtdAgendados'] + ' / ';
                                }

                                vagasRestantes = vagasRestantes < 0 ? 0 : vagasRestantes;
                                html += '<b>Vagas Restantes: </b>' + vagasRestantes  + '<br />';

                                $('#modal-cabecalho').append(html);
                            }

                            //Criando o select para seleção dos mapas (horários)
                            var option = "";
                            option += '<option value="">Selecione um mapa (horário)</option>';
                            for (var j = 0; j < json['mapas'].length; j++) {
                                option += '<option value="' + json['mapas'][j]['id'] + '">' + json['mapas'][j]['horario'] + ' - ' + json['mapas'][j]['especialidade']+ '</option>';
                            }

                            $('#hora option').remove();
                            $('#hora').prepend(option);

                            // Abrindo o modal para agendamento
                            $("#modal-agendamento").modal({show: true});

                        } else {
                            swal("Não é possível fazer agendamentos para este dia");
                        }
                    });
                },
                viewRender: function (view) {
                    var calendarDate = $("#calendar").fullCalendar('getDate');
                    var calendarMonth = calendarDate.month();
                    $('.block-header-calendar > h2 > span').html(view.title);
                },
                eventClick: function (calEvent, jsEvent, view) {

                    var date = calEvent.start._i;
                    var idPaciente = calEvent.idAgendamento;

                    jQuery.ajax({
                        url: '{{ route('serbinario.agendamento.edit') }}',
                        type: 'POST',
                        dataType: 'json',
                        data: {'id': idPaciente},
                        success: function (data) {

                            // Pega o id do agendamento (paciente)
                            $('#id').val(data['paciente']['id']);

                            var html = "";

                            // Monta as informações do paciente no modal
                            html += '<tr><td><b>Nome do paciente</b></td><td>' + data['paciente']['nome'] + '</td></tr>';
                            html += '<tr><td><b>Horário</b></td><td>' + data['paciente']['horario'] + '</td></tr>';
                            html += '<tr><td><b>Exame</b></td><td>' + data['paciente']['especialidade'] + '</td></tr>';
                            html += '<tr><td><b>Situação</b></td><td>' + data['paciente']['situacao'] + '</td></tr>';

                            // Valida se tem observação ou não, para não exibir o (NULL) vindo de um registro vazio do banco
                            if(data['paciente']['obs']) {
                                html += '<tr><td colspan="2"><b>Obserção: </b> ' + data['paciente']['obs'] + '</td></tr>';
                            } else {
                                html += '<tr><td colspan="2"><b>Obserção:</b></td></tr>';
                            }

                            $('#table-dados-paciente tbody tr').remove();
                            $('#table-dados-paciente tbody').append(html);

                            $("#modal-evento-agendamento").modal({show: true});
                        }
                    });
                }
            });

            //Calendar views switch
            $('body').on('click', '[data-calendar-view]', function(e){
                e.preventDefault();
                $('[data-calendar-view]').removeClass('active');
                $(this).addClass('active');
                var calendarView = $(this).attr('data-calendar-view');
                target.fullCalendar('changeView', calendarView);
            });
            //Calendar Next
            $('body').on('click', '.calendar-next', function (e) {
                e.preventDefault();
                target.fullCalendar('prev');
            });
            //Calendar Prev
            $('body').on('click', '.calendar-prev', function (e) {
                e.preventDefault();
                target.fullCalendar('next');
            });
        });

        //Buscando as vagas disponíveis ao selecionar o mapa (hotário)
        $(document).on('change', "#hora", function () {

            var mapa = $(this).val();

            if(mapa && idDoCalendario) {

                var dados = {
                    'mapa' : mapa,
                    'idCalendario' : idDoCalendario
                };

                jQuery.ajax({
                    type: 'POST',
                    url: '/serbinario/calendario/getVagasByMapa',
                    datatype: 'json',
                    data    : dados
                }).done(function (json) {

                    // Preenchendo as variáveis globais
                    var totalVagas = json['totalVagas'];
                    var vagasRestantes = json['vagasRestantes'];

                    if (vagasRestantes == '0') {

                        swal('O Limite de vagas para esse mapa (horário) foi atingido!', "Click no botão abaixo!", 'warning');

                        // Desabilitando o botão de salvar por tipo de perfil de usuário
                        @role('submaster')
                             $('#save').attr('disabled', true);
                        @endrole
                        @role('master|admin')
                             $('#save').attr('disabled', false);
                        @endrole

                    } else {
                        // Habilitando o botão de salvar
                        $('#save').prop('disabled', false);
                    }

                });

            } else {
                $('#save').attr('disabled', true);
            }

        });
    </script>
@stop