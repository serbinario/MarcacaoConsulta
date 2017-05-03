@extends('menu')

@section('css')
    <style type="text/css" class="init">
        td.details-control {
            background: url({{asset("/imagemgrid/icone-produto-plus.png")}}) no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url({{asset("/imagemgrid/icone-produto-minus.png")}}) no-repeat center center;
        }


        a.visualizar {
            background: url({{asset("/imagemgrid/impressao.png")}}) no-repeat 0 0;
            width: 23px;
        }

        td.bt {
            padding: 10px 0;
            width: 126px;
        }

        td.bt a {
            float: left;
            height: 22px;
            margin: 0 10px;
        }
        .highlight {
            background-color: #FE8E8E;
        }
    </style>
@endsection

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-md-10">
                <h4>
                    <i class="fa fa-users"></i>
                    Listar Especialistas
                </h4>
            </div>
            <div class="col-md-2">
                <a href="{{ route('serbinario.especialista.create')}}" class="btn-sm btn-primary">Novo Especialista</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="especialista-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th style="width: 2%;">Especialidades</th>
                                <th>Especialista</th>
                                <th>CRM</th>
                                <th>Quantidade de vagas</th>
                                <th>Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Especialidades</th>
                                <th>Especialista</th>
                                <th>CRM</th>
                                <th>Quantidade de vagas</th>
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

        function format(d) {

            var html = "";

           for(var i = 0; i < d['especialidades'].length; i++) {
               html += '<span>'+d['especialidades'][i]['nome']+'</span><br />';
           }

            return html;
        }

        var table = $('#especialista-grid').DataTable({
            processing: true,
            serverSide: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json'
            },
            ajax: "{!! route('serbinario.especialista.grid') !!}",
            columns: [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           'cgm.nome',
                    "defaultContent": ''
                },
                {data: 'nome', name: 'cgm.nome'},
                {data: 'crm', name: 'especialista.crm'},
                {data: 'qtd_vagas', name: 'especialista.qtd_vagas'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        // Add event listener for opening and closing details
        $('#especialista-grid tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data()) ).show();
                tr.addClass('shown');
            }
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
