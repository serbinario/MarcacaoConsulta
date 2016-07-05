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
                        <div class="panel-heading">AGENDAS PROFISSIONAIS</div>
                        <div class="panel-body">
                            {!! Form::open(['route'=>'serbinario.agendamento.calendar', 'method' => "POST", 'id' => 'formPS']) !!}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control" name="localidade" id="localidade">
                                        <option>Localidades</option>
                                        @foreach($localidades as $localidade)
                                            <option value="{{$localidade['id']}}">{{$localidade['nome']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control" id="especialidade" name="especialidade">
                                        <option>Especialidades</option>
                                        @foreach($especialidades as $especialidade)
                                            <option value="{{$especialidade['id']}}">{{$especialidade['nome']}}</option>
                                        @endforeach
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
                                    <input type="submit" value="Consultar" class="btn btn-primary">
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
                            <span class="total-vagas ocultar"></span>
                            <span class="total-agendados ocultar"></span>
                            <span class="vagas-restantes ocultar"></span><br />
                        </div>
                        <form method="post" id="form_agendamento">
                            <div class="modal-body" style="alignment-baseline: central">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <select class="form-control" name="cgm_id" id="cgm">

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
                                <button class="btn btn-warning" id="edit">Editar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            cgm();
                    @include('selects')
            @if(isset($dados))
                var idEspecialista = "{{$dados['especialista']}}";
                var idLocalidade = "{{$dados['localidade']}}";
                var idEspecialidade = "{{$dados['especialidade']}}";
            localidade(idLocalidade);
            especialidade(idEspecialidade);
            especialistas(idEspecialidade, idEspecialista);
            @else
                var idEspecialista = "";
                var idLocalidade = "";
            @endif

            var dados = {
                'idEspecialista': idEspecialista,
                'idLocalidade': idLocalidade
            }

            $('#calendar').fullCalendar({
                editable: true,
                eventLimit: true,

                //Carrega os eventos no fullcalendar
                events: function (start, end, timezone, callback) {
                    jQuery.ajax({
                        url: '/serbinario/agendamento/loadCalendar',
                        headers: {
                            'X-CSRF-TOKEN': '{{  csrf_token() }}'
                        },
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

                eventRender: function (event, element) {

                },

                //Envento do click no dia do calendário
                dayClick: function (date, allDay, jsEvent, view, resourceObj) {
                    var idMedico = idEspecialista;
                    var idLocal = idLocalidade;
                    var data = date.format();

                    //Dados do para validar médico
                    var dados = {
                        idMedico: idMedico,
                        data: data,
                        idLocalidade : idLocal
                    }

                    jQuery.ajax({
                        type: 'POST',
                        url: '/serbinario/calendario/calendariodatamedico',
                        headers: {
                            'X-CSRF-TOKEN': '{{  csrf_token() }}'
                        },
                        data: dados,
                        datatype: 'json'
                    }).done(function (json) {

                        if (json['retorno'] === true) {

                            $('#calendario').val(json['calendario'][0]['id']);
                            $('#data').val(json['calendario'][0]['data']);
                            $('#cgm option').remove();
                            cgm()

                            var vagasRestantes = json['calendario'][0]['qtd_vagas'] - json['calendario'][0]['agendamento'].length;

                            $('.total-vagas').html("<b>Total de Vagas:</b> " + json['calendario'][0]['qtd_vagas'] + " / ");
                            if(vagasRestantes <= "0") {
                                $('.total-agendados').html("<b>Total de Agendados: </b>" + "<span style='color: red' '>" + json['calendario'][0]['agendamento'].length + "</span>" + " / ");
                            } else {
                                $('.total-agendados').html("<b>Total de Agendados: </b>" + json['calendario'][0]['agendamento'].length + " / ");
                            }
                            vagasRestantes = vagasRestantes < 0 ? 0 : vagasRestantes;
                            $('.vagas-restantes').html("<b>Vagas Restantes: </b>" + vagasRestantes );
                           // console.log(json['calendario'][0]['agendamento'].length);
                            psfs();
                            $('#obs').text('');

                            if(vagasRestantes <= "0") {
                                @role('submaster')
                                    $('#save').attr('disabled', true);
                                @endrole
                                 @role('master|admin')
                                    $('#save').attr('disabled', false);
                                @endrole
                            } else {
                                $('#save').attr('disabled', false);
                            }

                            $('#edit').attr('disabled', true);
                            $("#modalCGM").modal({show: true});
                        } else {
                            //$('#especialista').val("");
                            alert("Não é possível fazer agendamentos para este dia");
                        }

                    });
                },

                //Evento do click no objeto
                eventClick: function(calEvent, jsEvent, view) {
                    var date       = calEvent.start._i;
                    var idPaciente = calEvent.idAgendamento;

                    console.log(calEvent.idAgendamento);
                    jQuery.ajax({
                        url: '{{ route('serbinario.agendamento.edit') }}',
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{  csrf_token() }}'
                        },
                        data: {
                            'id' :idPaciente
                        },
                        success: function (data) {

                            console.log(data['model']['cgm']);
                            $('#calendario').val(data['model']['calendario_id']);
                            $('#data').val(date);
                            $('#id').val(data['model']['id']);
                            $('#obs').text(data['model']['obs']);
                            psfs(data['model']['posto_saude_id']);

                            var option = '<option selected value="' + data['model']['cgm']['id'] + '">' + data['model']['cgm']['nome'] + '</option>'
                            $('#cgm option').remove();
                            $('#cgm').append(option);
                            //$("#cgm").select2("updateResults");
                           cgm();

                            $('.total-vagas').html('');
                            $('.total-agendados').html('');
                            $('.vagas-restantes').html('');

                            $('#save').attr('disabled', true);
                            $('#edit').attr('disabled', false);
                            $("#modalCGM").modal({show: true});
                        }
                    });

                },

            });

        });

        //Carregando os especialidades
        $(document).on('change', "#especialidade", function () {
            //Removendo as Bairros
            $('#especialista option').remove();

            //Recuperando a cidade
            var especialidade = $(this).val();

            if (especialidade !== "") {
                var dados = {
                    'especialidade': especialidade,
                }

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('serbinario.especialista.byespecialidade')  }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
                    },
                    data: dados,
                    datatype: 'json'
                }).done(function (json) {
                    console.log(json['especialistas'][0]['get_cgm']);
                    var option = "";

                    option += '<option value="">Selecione um Especialista</option>';
                    for (var i = 0; i < json['especialistas'].length; i++) {
                        option += '<option value="' + json['especialistas'][i]['id'] + '">' + json['especialistas'][i]['get_cgm']['nome'] + '</option>';
                    }

                    $('#especialista option').remove();
                    $('#especialista').append(option);
                });
            }
        });


        //Ações do formulário
        $(document).ready(function () {
            //Salvar formulário
            $("#save").click(function (event) {
                event.preventDefault();
                var dados = {
                    'cgm_id': $('#cgm').val(),
                    'calendario_id': $('#calendario').val(),
                    'posto_saude_id': $('#psf').val(),
                    'obs': $('#obs').val(),
                    'status': '1'
                }

                $.ajax({
                    url: "/serbinario/agendamento/store",
                    data: {
                        agendamento: dados,
                        dataEvento: $('#data').val(),
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
                        alert(data['msg']);
                        $("#calendar").fullCalendar("refetchEvents");
                        $("#modalCGM").modal('hide');

                    }
                });
            });
        });

        //Ações do formulário
        $(document).ready(function () {
            //editar formulário
            $("#edit").click(function (event) {
                event.preventDefault();
                var dados = {
                    'cgm_id': $('#cgm').val(),
                    'calendario_id': $('#calendario').val(),
                    'posto_saude_id': $('#psf').val(),
                    'obs': $('#obs').val(),
                    'status': '1'
                }

                $.ajax({
                    url: "/serbinario/agendamento/update/" + $('#id').val(),
                    data: {
                        agendamento: dados,
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
                    },
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
                        alert(data['msg']);
                        $("#calendar").fullCalendar("refetchEvents");
                        $("#modalCGM").modal('hide');
                    }
                });
            });
        });


        //consulta via select2 cgm
        function cgm () {
            $("#cgm").select2({
                placeholder: 'Selecione um cgm',
                minimumInputLength: 3,
                width: 400,
                ajax: {
                    type: 'POST',
                    url: "{{ route('serbinario.util.select2')  }}",
                    dataType: 'json',
                    delay: 250,
                    crossDomain: true,
                    data: function (params) {
                        return {
                            'search':     params.term, // search term
                            'tableName':  'cgm',
                            'fieldName':  'nome',
                            /*'fieldWhere':  'nivel',
                             'valueWhere':  '3',*/
                            'page':       params.page
                        };
                    },
                    headers: {
                        'X-CSRF-TOKEN' : '{{  csrf_token() }}'
                    },
                    processResults: function (data, params) {

                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    }
                }
            });
        };

    </script>
@stop
@stop
