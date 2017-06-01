@extends('menu')

@section('css')
    <style type="text/css" class="init">
        .aberto {
            background-color: #caebd7;
        }

        .fechado {
            background-color: #eeb5ba;
        }

        .bloqueado {
            background-color: #f7d2a4;
        }

        .row_selected {
            background-color: #f7d2a4;
        }

    </style>
@endsection

@section('content')
    <div class="container">
        <section id="content">
            {{-- Mensagem de alerta quando os dados não atendem as regras de validação que foramd efinidas no servidor --}}
            <div class="ibox-content">

            </div>

            <div class="block-header">
                <h2>Agenda Médica - {{ $especialista['getCgm']['nome'] }}</h2>
            </div>

            <div class="card">
                <div class="card-body card-padding">
                    <div class="row">
                        <div role="tabpanel" class="tab">

                            <ul class="tab-nav" role="tablist">
                                <li class="active"><a href="#calendario" aria-controls="calendario" role="tab"
                                                      data-toggle="tab"
                                                      aria-expanded="true">Criação do Calendário</a></li>
                                <li role="presentation" class=""><a href="#quadro" aria-controls="quadro" role="tab"
                                                                    data-toggle="tab"
                                                                    aria-expanded="false">Quadro do Calendário</a></li>
                            </ul>

                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane animated fadeInRight active" id="calendario">

                                    <br/>

                                    <div class="row">
                                        <div class="col-md-5 col-md-offset-1">
                                            <!-- define the calendar element -->
                                            <div class="row">
                                                <div id="my-calendar"></div>
                                            </div>
                                            <div class="row">
                                                <div class="row">
                                                    <div class="form-group col-md-10">
                                                        <button type="button" id="save" disabled
                                                                class="btn btn-primary btn-sm m-t-10">Salvar
                                                        </button>
                                                        <button type="button" id="edit" disabled
                                                                class="btn btn-success btn-sm m-t-10">Editar
                                                        </button>
                                                        <button type="button" id="fechar" disabled
                                                                class="btn btn-danger btn-sm m-t-10">Fechar
                                                        </button>
                                                        <button type="button" id="bloquear" disabled
                                                                class="btn btn-warning btn-sm m-t-10">Bloquear
                                                        </button>
                                                        <a href="{{route('serbinario.especialista.index')}}"
                                                           class="btn btn-default btn-sm m-t-10">Voltar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <form method="post" id="form_agenda">
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div class="form-group col-md-10">
                                                                <div class="fg-line">
                                                                    {!! Form::label('localidades', 'Unidade de Atendimento') !!}
                                                                    {!! Form::select('localidade_id', array(), array(),array('class' => 'form-control input-sm', 'id' => 'localidades')) !!}
                                                                    <input type="hidden" id="especialista_id"
                                                                           name="especialista_id"
                                                                           value="{{ $especialista['id'] }}">
                                                                </div>
                                                            </div>


                                                            <div class="form-group col-md-10">
                                                                <div class="fg-line">
                                                                    {!! Form::label('qtd_vagas', 'Quantidade de vagas') !!}
                                                                    {!! Form::text('qtd_vagas', $especialista['qtd_vagas'] , array('class' => 'form-control input-sm', 'id' => 'qtd_vagas')) !!}
                                                                </div>
                                                            </div>
                                                            <div class=" col-md-10">
                                                                <div class="fg-line">
                                                                    {!! Form::label('data', 'Data') !!}
                                                                    {!! Form::text('data', '', array('class' => 'form-control data input-sm', 'readonly' => 'readonly', 'id' => 'data')) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="fg-line">
                                                                    <div class="checkbox m-b-15">
                                                                        <label>
                                                                            <input type="checkbox" name="mais_mapa"
                                                                                   id="mapa" value=""><i
                                                                                    class="input-helper"></i>
                                                                            Possui mais de um mapa?
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="fg-line">
                                                                    {!! Form::label('hora', 'Hora Mapa 1') !!}
                                                                    {!! Form::text('hora', '', array('class' => 'form-control hora input-sm', 'id' => 'hora')) !!}
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <div class="fg-line">
                                                                    {!! Form::label('especialidade_um', 'Especialidade') !!}
                                                                    {!! Form::select('especialidade_um', array(), array(),array('class' => 'form-control input-sm', 'id' => 'especialidade_um')) !!}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="fg-line">
                                                                    {!! Form::label('hora2', 'Hora Mapa 2') !!}
                                                                    {!! Form::text('hora2', '', array('class' => 'form-control hora', 'id' => 'hora2', 'readonly' => 'readonly')) !!}
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <div class="fg-line">
                                                                    {!! Form::label('especialidade_dois', 'Especialidade') !!}
                                                                    {!! Form::select('especialidade_dois', array(), array(),array('disabled' => 'disabled', 'class' => 'form-control input-sm', 'id' => 'especialidade_dois')) !!}
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Grid dos paciente por data do calendário --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" disabled id="reagendarPaciente" class="btn btn-primary btn-sm m-t-10">Reagendar</button>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="pacientes-grid" class="display table table-bordered compact" cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Paciente</th>
                                                        <th>Horário</th>
                                                        <th>Exame</th>
                                                        <th>Situação</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>Paciente</th>
                                                        <th>Horário</th>
                                                        <th>Situação</th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <div role="tabpanel" class="tab-pane animated fadeInRight" id="quadro">
                                    <br/>

                                    <table class="table" style="width: 100%">
                                        <thead>
                                        <tr style="background-color: dimgrey">
                                            <th>Especialista</th>
                                            <th>Data</th>
                                            <th>Local</th>
                                            <th>Mapas</th>
                                            <th>Especialidades</th>
                                            <th>Vagas</th>
                                            <th>Vaga total</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($calendarios as $calendario)
                                            <tr>
                                                <td>{{$calendario->nome}}</td>
                                                <td>{{$calendario->data}}</td>
                                                <td>{{$calendario->localidade}}</td>
                                                <td>
                                                    @if($calendario->mais_mapa == '1')
                                                        {{$calendario->hora}}<br/>
                                                        {{$calendario->hora2}}<br/>
                                                    @else
                                                        {{$calendario->hora}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($calendario->mais_mapa == '1')
                                                        <span>Mapa1: </span>{{$calendario->mapa1->especialidade}}<br/>
                                                        <span>Mapa2: </span>{{$calendario->mapa2->especialidade}}<br/>
                                                    @else
                                                        {{$calendario->mapa1->especialidade}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($calendario->mais_mapa == '1')
                                                        <span>Mapa1: </span>{{$calendario->mapa1->qtdAgendados}}<br/>
                                                        <span>Mapa2: </span>{{$calendario->mapa2->qtdAgendados}}<br/>
                                                    @else
                                                        {{$calendario->mapa1->qtdAgendados}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($calendario->mais_mapa == '1')
                                                        <span>Mapa1: </span>{{$calendario->qtd_vagas / 2}}<br/>
                                                        <span>Mapa2: </span>{{$calendario->qtd_vagas / 2}}<br/>
                                                    @else
                                                        {{$calendario->qtd_vagas}}
                                                    @endif
                                                </td>
                                                <td>{{$calendario->status}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('calendario.modal_reagendamento')
@stop

@section('javascript')
    <script type="text/javascript" src="{{asset('/js/agenda/selects.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/agenda/operacoes.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/agenda/grid_pacientes.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/agenda/loadFields_reagendamento.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/agenda/modal_reagendamento.js')}}"></script>

    <!-- initialize the calendar on ready -->
    <script type="application/javascript">

        // Evento para abrir o modal de telefones
        $(document).on("click", "#reagendarPaciente", function () {

            // Executando o modal
            runModalReagendarPacientes(especialidadeId, idsPacientes, especialistaNome, CRM);
        });

        $(document).ready(function () {

            idEspecialista = "{{$especialista['id']}}";

            //Carregando as localidades
            localidade();
            especialidadesUm("", idEspecialista);

            //Calendário
            $("#my-calendar").zabuto_calendar({
                cell_border: true,
                today: true,
                show_days: false,
                weekstartson: 0,
                nav_icon: {
                    prev: '<button class="btn btn-info  btn-xs waves-effect waves-circle"><i class="zmdi zmdi-arrow-back"></i> </button>',
                    next: '<button class="btn btn-info  btn-xs waves-effect waves-circle"><i class="zmdi zmdi-arrow-forward"></i> </button>'
                },
                action: function () {
                    return myDateFunction(this.id, false);
                },
                ajax: {
                    url: "{{route('serbinario.calendario.calendarios', ['id' => $especialista['id']])}}",
                }
            });

            //Pega o evento da data
            function myDateFunction(id) {

                var date = $("#" + id).data("date");
                var hasEvent = $("#" + id).data("hasEvent");
                $('.data').val(toDate(date));

                if (hasEvent) {

                    var dados = {
                        'date': date
                    };

                    jQuery.ajax({
                        type: 'POST',
                        url: '{{route('serbinario.calendario.calendariodata')}}',
                        datatype: 'json',
                        data: dados,
                    }).done(function (json) {

                        // Carregando os selectes
                        localidade(json['calendario']['localidade_id']);
                        especialidadesUm(json['calendario']['especialidade_id_um'], idEspecialista);

                        $('#especialista_id').val(json['calendario']['especialista_id']);
                        $('#data').val(toDate(json['calendario']['data']));
                        $('#hora').val(json['calendario']['hora']);
                        $('#hora2').val(json['calendario']['hora2']);
                        json['calendario']['mais_mapa'] == '1' ? $('#mapa').prop('checked', true) : $('#mapa').attr('checked', false);
                        idCalendario = json['calendario']['id'];
                        var status = json['calendario']['status'];

                        runModalAdicionarPacientes(idCalendario);

                        var qtdVagas = 0;
                        if (json['calendario']['mais_mapa'] == '1') {
                            qtdVagas = json['calendario']['qtd_vagas'] / 2;

                            // Habilitando os campos do segundo mapa
                            $('#hora2').prop('readonly', false);
                            $('#especialidade_dois').prop('disabled', false);
                            especialidadesDois(json['calendario']['especialidade_id_dois'], idEspecialista);
                        } else {
                            qtdVagas = json['calendario']['qtd_vagas'];

                            // Desabilitando os campos do segundo mapa
                            $('#hora2').prop('readonly', true);
                            $('#especialidade_dois').prop('disabled', true);
                            $('#especialidade_dois option').remove();
                        }

                        // Preenchendo o campo vaga
                        $('#qtd_vagas').val(qtdVagas);


                        $('#data').prop('readonly', false);
                        $('#edit').attr('disabled', false);
                        $('#fechar').attr('disabled', false);
                        $('#bloquear').attr('disabled', false);
                        $('#save').attr('disabled', true);
                    });
                } else {
                    localidade();
                    especialidadesUm("", idEspecialista);
                    $('#qtd_vagas').val({{$especialista['qtd_vagas']}});
                    $('#hora').val("");
                    $('#hora2').val("");
                    $('#hora2').prop('readonly', true);
                    $('#especialidade_dois').prop('disabled', true);
                    $('#especialidade_dois option').remove();
                    $('#mapa').prop('checked', false);

                    $('#data').prop('readonly', true);
                    $('#save').attr('disabled', false);
                    $('#edit').attr('disabled', true);
                }
            };

        });
    </script>
@stop
