@extends('menu')

@section('content')
    <section id="content">
        <div class="container">

            <div class="block-header">
                <h2>Listar Operações</h2>
            </div>

            <div class="card material-table">
                <div class="card-header">
                    <!-- Botão novo -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="text-right">
                                <a class="btn btn-primary btn-sm m-t-10" href="{{ route('serbinario.operacao.create')}}">Nova Operação</a>
                            </div>
                        </div>
                    </div>
                    <!-- Botão novo -->
                </div>

                <div class="card-body card-padding">
                    <div class="table-responsive no-padding">
                        <table id="operacao-grid" class="display table table-bordered compact" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Grupo de operação</th>
                                <th>Operação</th>
                                <th>Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Grupo de operação</th>
                                <th>Operação</th>
                                <th style="width: 17%;">Acão</th>
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
        var table = $('#operacao-grid').DataTable({
            processing: true,
            serverSide: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json'
            },
            ajax: "{!! route('serbinario.operacao.grid') !!}",
            columns: [
                {data: 'grupo', name: 'grupo_operacoes.nome'},
                {data: 'nome', name: 'operacoes.nome'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

    </script>
@stop
