@extends('menu')

@section('content')
    <section id="content">
        <div class="container">

            <div class="block-header">
                <h2>Relatório por Agenda</h2>
            </div>

            <div class="card material-table">
                <div class="card-header">
                    <!-- Botão novo -->
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <div class=" fg-line">
                                <label for="especialista">Especialistas *</label>
                                <div class="select">
                                    {!! Form::select('especialista', ["" => 'Selecione um especialista'] + $especialistas, null, array('id' => 'especialista', 'class'=> 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <div class=" fg-line">
                                <label for="especialidade">Especialidade *</label>
                                <div class="select">
                                    {!! Form::select("especialidade", array(), null, array('class'=> 'form-control', 'id' => 'especialidade')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <div class=" fg-line">
                                <label for="localidade">Localidade *</label>
                                <div class="select">
                                    {!! Form::select("localidade", array(), null, array('class'=> 'form-control', 'id' => 'localidade')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <div class=" fg-line">
                                <label for="horario">Horário *</label>
                                <div class="select">
                                    {!! Form::select("horario", array(), null, array('class'=> 'form-control', 'id' => 'horario')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <button id="btnPesquisar" class="btn btn-primary btn-sm m-t-10">Pesquisar</button>
                            <button id="btnPesquisarGerarPdf" class="btn bgm-orange btn-sm m-t-10">Gerar PDF</button>
                        </div>
                    </div>
                    <!-- Botão novo -->
                </div>

                <div class="card-body card-padding">
                    <div class="table-responsive">
                        <table id="report-grid" class="display table table-bordered compact" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Nº SUS</th>
                                <th>Horário do Agendamento</th>
                                <th>Especialidade</th>
                                <th>Localidade</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Paciente</th>
                                <th>Nº SUS</th>
                                <th>Horário do Agendamento</th>
                                <th>Especialidade</th>
                                <th>Localidade</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('javascript')
    <script type="text/javascript" src="{{asset('/js/relatorio/loadFields_relatorio_por_agenda.js')}}"></script>
    <script type="text/javascript">

        var table = $('#report-grid').DataTable({
            processing: true,
            serverSide: true,
            retrieve: true,
            ajax: {
                url: "/serbinario/relatorio/reportByAgenda",
                method: 'POST',
                data: function (d) {
                    d.especialista  = $('select[name=especialista] option:selected').val();
                    d.especialidade = $('select[name=especialidade] option:selected').val();
                    d.localidade    = $('select[name=localidade] option:selected').val();
                    d.horario       = $('select[name=horario] option:selected').val();
                }
            },
            columns: [
                {data: 'nome', name: 'cgm.nome'},
                {data: 'numero_sus', name: 'cgm.numero_sus'},
                {data: 'localidade', name: 'agendamento.localidade'},
                {data: 'hora', name: 'agendamento.hora'},
                {data: 'especialidade', name: 'operacoes.especialidade'}
            ]
        });

        //Enviando id do especialista como paramentro para o select no servidor (Botão pesquisar)
        $(document).on('click', '#btnPesquisar', function () {

            table.draw();
            e.preventDefault();

        });

        //Enviando id do especialista como paramentro para o select no servidor(Botão gerar pdf)
        $(document).on('click', '#btnPesquisarGerarPdf', function () {

            var idEspecialista = $('#selectEspecialista').val();

            if (!idEspecialista) {
                swal('Por favor, selecione um especialista.');
                return false;
            }

            window.open('/index.php/serbinario/relatorio/reportPdfByAgenda/' + idEspecialista, '_blank');
        });
    </script>
@stop
