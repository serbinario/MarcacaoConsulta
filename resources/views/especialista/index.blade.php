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
    <section id="content">
        <div class="container">

            <div class="block-header">
                <h2>Listar Especialistas</h2>
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
                                <a class="btn btn-primary btn-sm m-t-10" href="{{ route('serbinario.especialista.create')}}">Novo Especialista</a>
                            </div>
                        </div>
                    </div>
                    <!-- Botão novo -->
                </div>

                <div class="card-body card-padding">
                    <div class="table-responsive">
                        <table id="especialista-grid" class="display table table-bordered compact" cellspacing="0" width="100%">
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
    </section>
    @include('especialista.modal_adicionar_especialidades')
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/script-especialista/modal_adicionar_especialidades.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/script-especialista/loadFields.js') }}"></script>
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
            order: [[ 1, "asc" ]],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json'
            },
            ajax: "{!! route('serbinario.especialista.grid') !!}",
            columns: [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           'gen_cgm.nome',
                    "defaultContent": ''
                },
                {data: 'nome', name: 'gen_cgm.nome'},
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

        //Global idServidor
        var idEspecialista;

        // Evento para abrir o modal de telefones
        $(document).on("click", "#btnModalAdicionarEspecialidades", function () {

            // Recuperando o id do servidor
            idEspecialista = table.row($(this).parents('tr')).data().id;

            // Recuperando o nome e matrícula
            var nome    = table.row($(this).parents('tr')).data().nome;
            var crm   = table.row($(this).parents('tr')).data().crm;

            // prenchendo o titulo do nome e matrícula do servidor
            $('.Nome').text(nome);
            $('.CRM').text(crm);

            // Executando o modal
            runModalAdicionarEspecialidades(idEspecialista);
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

    </script>
@stop
