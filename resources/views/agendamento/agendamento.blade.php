@extends('menu')

@section('content')
    <div class="container">
        <section id="content">
            {{-- Mensagem de alerta quando os dados não atendem as regras de validação que foramd efinidas no servidor --}}
            {{-- <div class="ibox-content">
             </div>--}}

            {{--<div class="block-header">
                <h2>Agendamento</h2>
            </div>--}}

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
                    <div id="modalCGM" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile"
                         aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button class="close" type="button" data-dismiss="modal">×</button>
                                    <h3 class="modal-title">Agendar Paciente</h3><br />
                                    <div class="div-hora1">
                                        <span class="hora1"></span>
                                        <span class="total-vagas1 ocultar1"></span>
                                        <span class="total-agendados1 ocultar1"></span>
                                        <span class="vagas-restantes1 ocultar1"></span><br />
                                    </div>
                                    <div class="div-hora2">
                                        <span class="hora2"></span>
                                        <span class="total-vagas2 ocultar2"></span>
                                        <span class="total-agendados2 ocultar2"></span>
                                        <span class="vagas-restantes2 ocultar2"></span><br />
                                    </div>

                                </div>
                                <form method="post" id="form_agendamento">
                                    <div class="modal-body" style="alignment-baseline: central">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <select class="form-control" name="cgm_id" id="paciente">
                                                        </select>
                                                        <input type="hidden" id="calendario" name="calendario_id">
                                                        <input type="hidden" id="data" name="data">
                                                        <input type="hidden" id="id" name="id">
                                                    </div>
                                                </div>
                                                {{--<div class="col-md-7">
                                                    <div class="form-group">
                                                        <select class="form-control" name="posto_saude_is" id="psf">
                                                            <option value="">Selecione o posto de saúde</option>
                                                        </select>
                                                    </div>
                                                </div>--}}
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <select class="form-control" name="hora" id="hora">

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="obs">Observação</label>
                                                    <div class="form-group">
                                                        <textarea name="obs" id="obs" rows="4" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" disabled id="save">Salvar</button>
                                        <button class="btn btn-danger" id="delete">Deletar</button>
                                        {{--<button class="btn btn-warning" id="edit">Editar</button>--}}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('javascript')
    <script type="text/javascript" src="{{asset('/js/agendamento/selects.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/agendamento/script-agendamento.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var date = new Date();
            var m = date.getMonth();
            var y = date.getFullYear();
            var target = $('#calendar');
            // Campos da pesquisa zerados para carregamento inicial do calendáriowq
            var dados = {
                'idLocalidade': "",
                'idEspecialista': ""
            };
            // Submete a pesquisa para carregamento do calendário por especialista e localidade
            $('#btnConsultar').click(function () {
                var localidade = $('#localidade').val();
                var especialista = $('#especialista').val();
                var especialidade = $('#grupo_operacao').val();

                if (!localidade || !especialista || !especialidade) {
                    swal("Por favor, preencha todos os campos para consultar!");
                }

                if (localidade && especialista) {
                    dados = {
                        'idLocalidade': localidade,
                        'idEspecialista': especialista,
                    };
                    $('#calendar').fullCalendar('refetchEvents');
                    paciente("", especialidade);
                }
            });
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
                            console.log(doc);
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
                            console.log(doc);
                            callback(events);
                        }
                    });
                },
                dayClick: function (date, allDay, jsEvent, view, resourceObj) {
                    var idMedico        = $('#especialista').val();
                    var idLocal         = $('#localidade').val();
                    var especialidade   = $('#grupo_operacao').val();
                    var data = date.format();
                    //Dados do para validar médico
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
                            $('#calendario').val(json['calendario']['id']);
                            $('#data').val(json['calendario']['data']);
                            $('#obs').text('');
                            psfs();
                            paciente("", especialidade);
                            var TotalVagas = 0;
                            if (json['calendario']['hora2']) {
                                TotalVagas = json['calendario']['qtd_vagas'] / 2;
                            } else {
                                TotalVagas = json['calendario']['qtd_vagas'];
                            }
                            //Tratando os resultados para vagas hora 1
                            var vagasRestantes1 = TotalVagas - json['mapa1']['qtdAgendados'];
                            $('.hora1').html("<b>Mapa:</b> " + json['calendario']['hora'] + ": ");
                            $('.total-vagas1').html("<b>Total de Vagas:</b> " + TotalVagas + " / ");
                            // Verifica se as vagas para o primeiro mapa estão esgotados
                            if (vagasRestantes1 <= "0") {
                                $('.total-agendados1').html("<b>Total de Agendados: </b>" + "<span style='color: red' '>" + json['mapa1']['qtdAgendados'] + "</span>" + " / ");
                            } else {
                                $('.total-agendados1').html("<b>Total de Agendados: </b>" + json['mapa1']['qtdAgendados'] + " / ");
                            }
                            vagasRestantes1 = vagasRestantes1 < 0 ? 0 : vagasRestantes1;
                            $('.vagas-restantes1').html("<b>Vagas Restantes: </b>" + vagasRestantes1);
                            //Tratando os resultados para vagas hora 2
                            if (json['calendario']['hora2']) {
                                $('.div-hora2').show();
                                var vagasRestantes2 = TotalVagas - json['mapa2']['qtdAgendados'];
                                $('.hora2').html("<b>Mapa:</b> " + json['calendario']['hora2'] + ": ");
                                $('.total-vagas2').html("<b>Total de Vagas:</b> " + TotalVagas + " / ");
                                // Verifica se as vagas para o segundo mapa estão esgotados
                                if (vagasRestantes2 <= "0") {
                                    $('.total-agendados2').html("<b>Total de Agendados: </b>" + "<span style='color: red' '>" + json['mapa2']['qtdAgendados'] + "</span>" + " / ");
                                } else {
                                    $('.total-agendados2').html("<b>Total de Agendados: </b>" + json['mapa2']['qtdAgendados'] + " / ");
                                }
                                vagasRestantes2 = vagasRestantes2 < 0 ? 0 : vagasRestantes2;
                                $('.vagas-restantes2').html("<b>Vagas Restantes: </b>" + vagasRestantes2);
                            } else {
                                $('.div-hora2').hide();
                            }
                            //Validando habilitação do botão save para perfil de usuário
                            if (vagasRestantes1 <= "0") {
                                @role('submaster')
                                    $('#save').attr('disabled', true);
                                @endrole
                                 @role('master|admin')
                                    $('#save').attr('disabled', false);
                                @endrole
                            } else {
                                $('#save').attr('disabled', false);
                            }
                            //Combobox para hora
                            var option = "";
                            option += '<option value="' + json['calendario']['hora'] + '">' + json['calendario']['hora'] + ' - ' +json['mapa1']['especialidade']+ '</option>';
                            if (json['calendario']['hora2']) {
                                option += '<option value="' + json['calendario']['hora2'] + '">' + json['calendario']['hora2'] + ' - ' +json['mapa2']['especialidade']+ '</option>';
                            }
                            $('#hora option').remove();
                            $('#hora').prepend(option);
                            $('.div-hora1').show();
                            $('#delete').attr('disabled', true);
                            $("#modalCGM").modal({show: true});
                        } else {
                            swal("Não é possível fazer agendamentos para este dia");
                        }
                    });
                },
                viewRender: function (view) {
                    var calendarDate = $("#calendar").fullCalendar('getDate');
                    var calendarMonth = calendarDate.month();
                    //Set data attribute for header. This is used to switch header images using css
                    $('#calendar . fc-toolbar').attr('data-calendar-month', calendarMonth);
                    //Set title in page header
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
                            $('#calendario').val(data['model']['calendario_id']);
                            $('#data').val(date);
                            $('#id').val(data['model']['id']);
                            $('#obs').text(data['model']['obs']);
                            psfs(data['model']['posto_saude_id']);
                            //paciente(data['model']['fila']['id'], data['model']['fila']['especialidade_id']);
                            var optionPaciente = '<option selected value="' + data['model']['fila']['id'] + '">' + data['model']['fila']['cgm']['nome'] + '</option>'
                            $('#paciente option').remove();
                            $('#paciente').append(optionPaciente);
                            //Combobox para hora
                            var option = "";
                            // Regra para marcar como selecioando a hora da consulta do paciente - primeiro mapa
                            if (data['model']['calendario']['hora'] == data['model']['hora']) {
                                option += '<option selected value="' + data['model']['calendario']['hora'] + '">' + data['model']['calendario']['hora'] + '</option>';
                            } else {
                                option += '<option value="' + data['model']['calendario']['hora'] + '">' + data['model']['calendario']['hora'] + '</option>';
                            }
                            // Validando se existe um segundo mapa de consulta
                            if (data['model']['calendario']['hora2']) {
                                // Regra para marcar como selecioando a hora da consulta do paciente - segundo mapa
                                if (data['model']['calendario']['hora2'] == data['model']['hora']) {
                                    option += '<option selected value="' + data['model']['calendario']['hora2'] + '">' + data['model']['calendario']['hora2'] + '</option>';
                                } else {
                                    option += '<option value="' + data['model']['calendario']['hora2'] + '">' + data['model']['calendario']['hora2'] + '</option>';
                                }
                            }
                            $('#hora option').remove();
                            $('#hora').prepend(option);
                            $('.div-hora1').hide();
                            $('.div-hora2').hide();
                            $('#save').attr('disabled', true);
                            $('#delete').attr('disabled', false);
                            $("#modalCGM").modal({show: true});
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
    </script>
@stop