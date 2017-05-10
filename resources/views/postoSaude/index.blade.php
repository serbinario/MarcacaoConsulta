@extends('menu')

@section('content')
    <section id="content">
        <div class="container">

            <div class="block-header">
                <h2>Listar PSF(s)</h2>
            </div>

            <div class="card material-table">
                <div class="card-header">

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

                    <!-- Botão novo -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="text-right">
                                <a class="btn btn-primary btn-sm m-t-10" href="{{ route('serbinario.ps.create')  }}">Novo PSF</a>
                            </div>
                        </div>
                    </div>
                    <!-- Botão novo -->
                </div>

                <div class="card-body card-padding">
                    <div class="table-responsive">
                        <table id="ps-grid" class="display table table-bordered compact" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>cnes</th>
                                <th>Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>cnes</th>
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
        var table = $('#ps-grid').DataTable({
            processing: true,
            serverSide: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json'
            },
            ajax: "{!! route('serbinario.ps.grid') !!}",
            columns: [
                {data: 'nome', name: 'nome'},
                {data: 'cnes', name: 'cnes'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        // Deletar fila
        $(document).on('click', 'a.excluir', function (event) {
            event.preventDefault();
            var url = $(this).attr('href');
            swal({
                title: "Alerta",
                text: "Tem certeza da exclusão do item?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Sim!",
            }).then(function(){
                location.href = url;
            });
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
