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
                                <label for="sexo">Especialistas</label>
                                <div class="select">
                                    {!! Form::select('Especialistas', ["" => 'Selecione um especialista'] + $especialistas, null, array('id' => 'selectEspecialista', 'class'=> 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-1">
                            <a style="margin-right: 5px;" id="btnPesquisar" class="btn btn-primary btn-sm m-t-10">Pesquisar</a>
                        </div>
                        <div class="col-xs-2">
                            <a style="margin-left: 5px;" id="btnPesquisarGerarPdf" class="btn bgm-orange btn-sm m-t-10">Gerar PDF</a>
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
    <script type="text/javascript">
        //Enviando id da agenda como paramentro para o select
        $(document).on('click', '#btnPesquisar', function () {

            var idEspecialista = $('#selectEspecialista').val();

            var table = $('#report-grid').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/index.php/serbinario/relatorio/reportByAgenda/' + idEspecialista,
                columns: [
                    {data: 'nomePaciente', name: 'cgm.nomePaciente'},
                    {data: 'numero_sus', name: 'cgm.numero_sus'},
                    {data: 'localidade', name: 'agendamento.localidade'},
                    {data: 'hora', name: 'agendamento.hora'},
                    {data: 'especialidade', name: 'operacoes.especialidade'}
                ]
            })
        });
    </script>
@stop
