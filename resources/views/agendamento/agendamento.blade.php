@extends('menu')


@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h4>
                <i class="fa fa-user"></i>
                Agendamento
            </h4>
        </div>
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
            <div class="row">
                <div class="col-md-8">
                    <div id='calendar'></div>
                </div>
                <div class="col-md-4">
                    <br/><br/>

                    <div class="panel panel-primary">
                        <!-- Default panel contents -->
                        <div class="panel-heading">AGENDA ESPECIALISTA</div>
                        <div class="panel-body">
                            {!! Form::open(['route'=>'serbinario.agendamento.calendar', 'method' => "POST", 'id' => 'formPS']) !!}
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::select('localidade', ['' => 'Unidade de Atendimento'] + $loadFields['localidade']->toArray(), null, array('class' => 'form-control', 'id' => 'localidade')) !!}
                                    {{--<select class="form-control" name="localidade" id="localidade">
                                        <option>Localidades</option>
                                        @foreach($localidades as $localidade)
                                            <option value="{{$localidade['id']}}">{{$localidade['nome']}}</option>
                                        @endforeach
                                    </select>--}}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::select('tipo_operacao', ['' => 'Tipo de operação'] + $loadFields['tipooperacao']->toArray(), null, array('class' => 'form-control', 'id' => 'tipo_operacao')) !!}
                                    {{--<select class="form-control" id="tipo_operacao" name="Tipo Operação">
                                        <option>Tipo de operação</option>
                                        @foreach($tipoOperacoes as $tipooperacao)
                                            <option value="{{$tipooperacao['id']}}">{{$tipooperacao['nome']}}</option>
                                        @endforeach
                                    </select>--}}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control" name="grupo_operacao" id="grupo_operacao">
                                        <option>Grupo de operação</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control" name="especialista" id="especialista">
                                        <option>Especialista</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="button" id="btnConsultar" value="Consultar" class="btn btn-primary">
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>

                        <!-- List group -->
                        <ul class="list-group" id="medicosList">

                        </ul>
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
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <select class="form-control" name="posto_saude_is" id="psf">
                                                    <option value="">Selecione o posto de saúde</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select class="form-control" name="hora" id="hora">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="obs">Observação</label>
                                            <div class="form-group">
                                                <textarea name="obs" id="obs" rows="10" class="form-control"></textarea>
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
@stop
@section('javascript')
<script type="text/javascript" src="{{asset('/js/agendamento/selects.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/agendamento/script-agendamento.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {

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

            if (localidade && especialista) {

                dados = {
                    'idLocalidade': localidade,
                    'idEspecialista': especialista,
                };

                $('#calendar').fullCalendar('refetchEvents');

                paciente("", especialidade);
            }

        });

        $('#calendar').fullCalendar({
            editable: true,
            eventLimit: true,

            //Carrega os eventos no fullcalendar
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

            //Envento do click no dia do calendário
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
                        var vagasRestantes1 = TotalVagas - json['qtdVagaHora1']['agendamento_um'];
                        $('.hora1').html("<b>Mapa:</b> " + json['calendario']['hora'] + ": ");
                        $('.total-vagas1').html("<b>Total de Vagas:</b> " + TotalVagas + " / ");

                        // Verifica se as vagas para o primeiro mapa estão esgotados
                        if (vagasRestantes1 <= "0") {
                            $('.total-agendados1').html("<b>Total de Agendados: </b>" + "<span style='color: red' '>" + json['qtdVagaHora1']['agendamento_um'] + "</span>" + " / ");
                        } else {
                            $('.total-agendados1').html("<b>Total de Agendados: </b>" + json['qtdVagaHora1']['agendamento_um'] + " / ");
                        }

                        vagasRestantes1 = vagasRestantes1 < 0 ? 0 : vagasRestantes1;
                        $('.vagas-restantes1').html("<b>Vagas Restantes: </b>" + vagasRestantes1);

                        //Tratando os resultados para vagas hora 2
                        if (json['calendario']['hora2']) {
                            $('.div-hora2').show();

                            var vagasRestantes2 = TotalVagas - json['qtdVagaHora2']['agendamento_dois'];
                            $('.hora2').html("<b>Mapa:</b> " + json['calendario']['hora2'] + ": ");
                            $('.total-vagas2').html("<b>Total de Vagas:</b> " + TotalVagas + " / ");

                            // Verifica se as vagas para o segundo mapa estão esgotados
                            if (vagasRestantes2 <= "0") {
                                $('.total-agendados2').html("<b>Total de Agendados: </b>" + "<span style='color: red' '>" + json['qtdVagaHora2']['agendamento_dois'] + "</span>" + " / ");
                            } else {
                                $('.total-agendados2').html("<b>Total de Agendados: </b>" + json['qtdVagaHora2']['agendamento_dois'] + " / ");
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
                        option += '<option value="' + json['calendario']['hora'] + '">' + json['calendario']['hora'] + '</option>';
                        if (json['calendario']['hora2']) {
                            option += '<option value="' + json['calendario']['hora2'] + '">' + json['calendario']['hora2'] + '</option>';
                        }

                        $('#hora option').remove();
                        $('#hora').prepend(option);


                        $('#delete').attr('disabled', true);
                        $("#modalCGM").modal({show: true});
                    } else {
                        //$('#especialista').val("");
                        alert("Não é possível fazer agendamentos para este dia");
                    }

                });
            },

            //Evento do click no objeto
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

                        $('.total-vagas').html('');
                        $('.total-agendados').html('');
                        $('.vagas-restantes').html('');

                        $('#save').attr('disabled', true);
                        $('#delete').attr('disabled', false);
                        $("#modalCGM").modal({show: true});
                    }
                });

            }

        });
    });

</script>
@stop
