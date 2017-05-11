@extends('menu')

@section('content')
    <section id="content">
        <div class="container">

            <div class="block-header">
                <h2>Relatório Total de Atendimentos</h2>
            </div>

            <div class="card material-table">
                <div class="card-header">
                    <!-- Botão novo -->
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <div class=" fg-line">
                                <label for="data">Data</label>
                                <div class="select">
                                    {!! Form::select('data', ["" => 'Selecione uma data'] + $especialistas, null, array('id' => 'selectEspecialista', 'class'=> 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <a id="btnPesquisar" class="btn btn-primary btn-sm m-t-10">Pesquisar</a>
                        </div>
                    </div>
                    <!-- Botão novo -->
                </div>

                <div class="card-body card-padding">
                    <div class="table-responsive">
                        <table id="report-grid" class="display table table-bordered compact" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nome</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nome</th>
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
                ajax: '/MarcacaoConsulta/public/index.php/serbinario/relatorio/reportByAgenda/' + idEspecialista,
                columns: [
                    {data: 'nome', name: 'cgm.nome'}
                ]
            })
        });
    </script>
@stop
