@extends('menu')


@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h4>
                <i class="fa fa-user"></i>
                Agenda Médica - {{ $especialista['getCgm']['nome'] }}
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
                <div class="col-md-5 col-md-offset-1">
                    <!-- define the calendar element -->

                    <div id="my-calendar"></div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <form method="post" id="form_agenda">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            {!! Form::label('localidades', 'Unidade de Atendimento') !!}
                                            {!! Form::select('localidade_id', array(), array(),array('class' => 'form-control', 'id' => 'localidades')) !!}
                                            <input type="hidden" id="especialista_id" name="especialista_id" value="{{ $especialista['id'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            {!! Form::label('qtd_vagas', 'Quantidade de vagas') !!}
                                            {!! Form::text('qtd_vagas', $especialista['qtd_vagas'] , array('class' => 'form-control', 'id' => 'qtd_vagas')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            {!! Form::label('data', 'Data') !!}
                                            {!! Form::text('data', '', array('class' => 'form-control data', 'readonly' => 'readonly', 'id' => 'data')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkbox checkbox-primary">
                                            {!! Form::checkbox('mais_mapa', 1, null, array('class' => 'form-control', 'id' => 'mapa')) !!}
                                            {!! Form::label('mais_mapa', 'Possui mais de um mapa?', false) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            {!! Form::label('hora', 'Hora Mapa 1') !!}
                                            {!! Form::text('hora', '', array('class' => 'form-control hora', 'id' => 'hora')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            {!! Form::select('especialidade_um', array(), array(),array('class' => 'form-control', 'id' => 'especialidade_um')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            {!! Form::label('hora2', 'Hora Mapa 2') !!}
                                            {!! Form::text('hora2', '', array('class' => 'form-control hora', 'id' => 'hora2', 'readonly' => 'readonly')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            {!! Form::select('especialidade_dois', array(), array(),array('disabled' => 'disabled', 'class' => 'form-control', 'id' => 'especialidade_dois')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10">
                                        {!! Form::submit('Salvar', array('class' => 'btn btn-primary', 'disabled' => 'disabled', 'id' => 'save')) !!}
                                        {!! Form::submit('Editar', array('class' => 'btn btn-success', 'disabled' => 'disabled', 'id' => 'edit')) !!}
                                        <a href="{{route('serbinario.especialista.index')}}" class="btn btn-default">Voltar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('javascript')
            <!-- initialize the calendar on ready -->
    <script type="application/javascript">
        $(document).ready(function () {

            var idCalendario = "";
            var idEspecialista = "{{$especialista['id']}}";

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
                    prev: '<i class="fa fa-chevron-circle-left"></i>',
                    next: '<i class="fa fa-chevron-circle-right"></i>'
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

                if(hasEvent) {
                    var dados = {
                        'date' : date
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

                        var qtdVagas = 0;
                        if(json['calendario']['mais_mapa'] == '1') {
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
                        $('#save').attr('disabled', true);
                    });
                } else {
                    localidade();
                    especialidadesUm("", idEspecialista);
                    $('#qtd_vagas').val({{$especialista['qtd_vagas']}});
                    $('#hora').val("");
                    $('#hora2').val("");
                    $('#hora2').prop('readonly', true);
                    $('#mapa').prop('checked', false);

                    $('#data').prop('readonly', true);
                    $('#save').attr('disabled', false);
                    $('#edit').attr('disabled', true);
                }
            };


            $('#mapa').click(function(){
                if($('#mapa').is(":checked")) {
                    $('#hora2').prop('readonly', false);
                    $('#especialidade_dois').prop('disabled', false);
                    especialidadesDois("", idEspecialista);
                } else {
                    $('#hora2').prop('readonly', true);
                    $('#hora2').val("");
                    $('#especialidade_dois').prop('disabled', true);
                    $('#especialidade_dois option').remove();
                }
            });

            //Salvar formulário
            $("#save").click(function(event){
                event.preventDefault();
                var mapa = $('#mapa').is(":checked") == true ? '1' : '0';

                var dados = {
                    'localidade_id' : $('#localidades').val(),
                    'especialista_id' : $('#especialista_id').val(),
                    'qtd_vagas' : $('#qtd_vagas').val(),
                    'data' : $('#data').val(),
                    'hora' : $('#hora').val(),
                    'hora2' : $('#hora2').val(),
                    'mais_mapa' : mapa,
                    'especialidade_id_um' : $('#especialidade_um').val(),
                    'especialidade_id_dois' : $('#especialidade_dois').val()
                };

                if(!$('#mapa').is(":checked") && (!$('#localidades').val() || !$('#especialista_id').val() || !$('#qtd_vagas').val()
                        || !$('#data').val() || !$('#hora').val() || !$('#especialidade_um').val())) {
                    alert("O preenchimento de todos os campos são obrigatórios")
                } else if ($('#mapa').is(":checked") && (!$('#localidades').val() || !$('#especialista_id').val() || !$('#qtd_vagas').val() || !$('#data').val()
                        || !$('#hora').val() || !$('#especialidade_um').val() || !$('#hora2').val() || !$('#especialidade_dois').val())) {
                    alert('O preenchimento de todos os campos são obrigatórios');
                } else {
                    $.ajax({
                        url: "{{route('serbinario.calendario.store')}}",
                        data: {calendario:dados,},
                        dataType: "json",
                        type: "POST",
                        success: function(data){
                            alert(data['msg']);
                            location.href = "{{ route('serbinario.calendario.index', ['id' => $especialista['id']])  }}";
                        }
                    });
                }

            });

            //Editar formulário
            $("#edit").click(function(event){
                event.preventDefault();
                var mapa = $('#mapa').is(":checked") == true ? '1' : '0';
                var dados = {
                    'localidade_id' : $('#localidades').val(),
                    'especialista_id' : $('#especialista_id').val(),
                    'qtd_vagas' : $('#qtd_vagas').val(),
                    'data' : $('#data').val(),
                    'hora' : $('#hora').val(),
                    'hora2' : $('#hora2').val(),
                    'mais_mapa' : mapa,
                    'id' : $('#id').val(),
                    'especialidade_id_um' : $('#especialidade_um').val(),
                    'especialidade_id_dois' : $('#especialidade_dois').val()
                };

                if(!$('#mapa').is(":checked") && (!$('#localidades').val() || !$('#especialista_id').val() || !$('#qtd_vagas').val()
                        || !$('#data').val() || !$('#hora').val() || !$('#especialidade_um').val())) {
                    alert("O preenchimento de todos os campos são obrigatórios")
                } else if ($('#mapa').is(":checked") && (!$('#localidades').val() || !$('#especialista_id').val() || !$('#qtd_vagas').val() || !$('#data').val()
                        || !$('#hora').val() || !$('#especialidade_um').val() || !$('#hora2').val() || !$('#especialidade_dois').val())) {
                    alert('O preenchimento de todos os campos são obrigatórios');
                } else {
                    $.ajax({
                        url: "/index.php/serbinario/calendario/update/" + idCalendario,
                        data: {calendario:dados},
                        dataType: "json",
                        type: "POST",
                        success: function(data){
                            alert(data['msg']);
                            location.href = "{{ route('serbinario.calendario.index', ['id' => $especialista['id']])  }}";
                        }
                    });
                }

            });

            //Função para listar as localidades
            function localidade(id) {
                jQuery.ajax({
                    type: 'POST',
                    url: '{{route('serbinario.localidade.all')}}',
                    datatype: 'json',
                }).done(function (json) {
                    var option = '';

                    option += '<option value="">Selecione uma unidade de atendimento</option>';
                    for (var i = 0; i < json['localidades'].length; i++) {
                        if (json['localidades'][i]['id'] == id) {
                            option += '<option selected value="' + json['localidades'][i]['id'] + '">' + json['localidades'][i]['nome'] + '</option>';
                        } else {
                            option += '<option value="' + json['localidades'][i]['id'] + '">' + json['localidades'][i]['nome'] + '</option>';
                        }
                    }

                    $('#localidades option').remove();
                    $('#localidades').append(option);
                });
            }

            //Função para listar as especialidades do mapa 1
            function especialidadesUm(id, idEspecialista) {
                jQuery.ajax({
                    type: 'POST',
                    url: '{{route('serbinario.especialista.especialidades')}}',
                    datatype: 'json',
                    data: {'idEspecialista' : idEspecialista}
                }).done(function (json) {
                    var option = '';

                    option += '<option value="">Selecione uma especialidade</option>';
                    for (var i = 0; i < json['especialidades'].length; i++) {
                        if (json['especialidades'][i]['id'] == id) {
                            option += '<option selected value="' + json['especialidades'][i]['id'] + '">' + json['especialidades'][i]['nome'] + '</option>';
                        } else {
                            option += '<option value="' + json['especialidades'][i]['id'] + '">' + json['especialidades'][i]['nome'] + '</option>';
                        }
                    }

                    $('#especialidade_um option').remove();
                    $('#especialidade_um').append(option);
                });
            }

            //Função para listar as especialidades do mapa 2
            function especialidadesDois(id, idEspecialista) {
                jQuery.ajax({
                    type: 'POST',
                    url: '{{route('serbinario.especialista.especialidades')}}',
                    datatype: 'json',
                    data: {'idEspecialista' : idEspecialista}
                }).done(function (json) {
                    var option = '';

                    option += '<option value="">Selecione uma especialidade</option>';
                    for (var i = 0; i < json['especialidades'].length; i++) {
                        if (json['especialidades'][i]['id'] == id) {
                            option += '<option selected value="' + json['especialidades'][i]['id'] + '">' + json['especialidades'][i]['nome'] + '</option>';
                        } else {
                            option += '<option value="' + json['especialidades'][i]['id'] + '">' + json['especialidades'][i]['nome'] + '</option>';
                        }
                    }

                    $('#especialidade_dois option').remove();
                    $('#especialidade_dois').append(option);
                });
            }

            //converter data
            function toDate(dateStr) {
                from = dateStr.split("-");
                f = new Date(from[2], from[1] - 1, from[0]);
                return from[2] + '/' + from[1] + '/' + from[0]
            }
        });
    </script>
@stop
@stop