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
                                            {!! Form::label('localidades', 'Localidade') !!}
                                            {!! Form::select('localidade_id', array(), array(),array('class' => 'form-control', 'id' => 'localidades')) !!}
                                            <input type="hidden" id="especialista_id" name="especialista_id"
                                                   value="{{ $especialista['id'] }}">
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
                                            {!! Form::text('data', '', array('class' => 'form-control data', 'readonly' => 'readonly', 'data' => 'data')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            {!! Form::label('hora', 'Hora') !!}
                                            {!! Form::text('hora', '', array('class' => 'form-control hora', 'id' => 'hora')) !!}
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-10">
                                        {!! Form::submit('Salvar', array('class' => 'btn btn-primary', 'disabled' => 'disabled', 'id' => 'save')) !!}
                                        {!! Form::submit('Editar', array('class' => 'btn btn-success', 'disabled' => 'disabled', 'id' => 'edit')) !!}
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

            //Carregando as localidades
            localidade();

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
                },
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
                        headers: {
                            'X-CSRF-TOKEN': '{{  csrf_token() }}'
                        },
                    }).done(function (json) {
                        localidade(json['calendario'][0]['localidade_id']);
                        $('#especialista_id').val(json['calendario'][0]['especialista_id']);
                        $('#qtd_vagas').val(json['calendario'][0]['qtd_vagas']);
                        $('#data').val(toDate(json['calendario'][0]['data']));
                        $('#hora').val(json['calendario'][0]['hora']);
                        idCalendario = json['calendario'][0]['id'];

                        $('#edit').attr('disabled', false);
                        $('#save').attr('disabled', true);
                    });
                } else {
                    localidade();
                    $('#qtd_vagas').val({{$especialista['qtd_vagas']}});
                    $('#hora').val("");

                    $('#save').attr('disabled', false);
                    $('#edit').attr('disabled', true);
                }
            };


            //Salvar formulário
            $("#save").click(function(event){
                event.preventDefault();
                var dados = {
                    'localidade_id' : $('#localidades').val(),
                    'especialista_id' : $('#especialista_id').val(),
                    'qtd_vagas' : $('#qtd_vagas').val(),
                    'data' : $('#data').val(),
                    'hora' : $('#hora').val(),
                }

                $.ajax({
                    url: "{{route('serbinario.calendario.store')}}",
                    data: {calendario:dados,},
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    dataType: "json",
                    type: "POST",
                    success: function(data){
                        alert(data['msg']);
                        location.href = "{{ route('serbinario.calendario.index', ['id' => $especialista['id']])  }}";
                    }
                });
            });

            //Editar formulário
            $("#edit").click(function(event){
                event.preventDefault();
                var dados = {
                    'localidade_id' : $('#localidades').val(),
                    'especialista_id' : $('#especialista_id').val(),
                    'qtd_vagas' : $('#qtd_vagas').val(),
                    'data' : $('#data').val(),
                    'hora' : $('#hora').val(),
                    'id' : $('#id').val(),
                }

                $.ajax({
                    url: "/serbinario/calendario/update/" + idCalendario,
                    data: {calendario:dados},
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
                    },
                    dataType: "json",
                    type: "POST",
                    success: function(data){
                        alert(data['msg']);
                        location.href = "{{ route('serbinario.calendario.index', ['id' => $especialista['id']])  }}";
                    }
                });
            });

            //Função para listar as localidades
            function localidade(id) {
                jQuery.ajax({
                    type: 'POST',
                    url: '{{route('serbinario.localidade.all')}}',
                    datatype: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
                    },
                }).done(function (json) {
                    var option = '';

                    option += '<option value="">Selecione a localidade</option>';
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
