@extends('menu')

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-md-10">
                <h4>
                    <i class="fa fa-users"></i>
                    Fila de espera
                </h4>
            </div>
            <div class="col-md-2">
                <a href="{{ route('serbinario.fila.create')}}" class="btn-sm btn-primary">Adicionar na fila</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="fila-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Cidadão</th>
                                <th>Exame</th>
                                <th>Prioridade</th>
                                <th>Data do cadastro</th>
                                <th>Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Cidadão</th>
                                <th>Exame</th>
                                <th>Prioridade</th>
                                <th>Data do cadastro</th>
                                <th style="width: 17%;">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">
        var table = $('#fila-grid').DataTable({
            processing: true,
            serverSide: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json'
            },
            ajax: "{!! route('serbinario.fila.grid') !!}",
            columns: [
                {data: 'nome', name: 'cgm.nome'},
                {data: 'especialidade', name: 'operacoes.nome'},
                {data: 'prioridade', name: 'prioridade.nome'},
                {data: 'data_cadastro', name: 'fila.data'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        /*//Seleciona uma linha
        $('#crud-grid tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

        //Retonra o id do registro
        $('#crud-grid tbody').on( 'click', 'tr', function () {

            var rows = table.row( this ).data()

            console.log( rows.id );
        } );*/

    </script>
@stop
