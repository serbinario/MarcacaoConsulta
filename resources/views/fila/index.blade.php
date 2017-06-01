@extends('menu')

@section('content')
    <section id="content">
        <div class="container">

            <div class="block-header">
                <h2>Fila de Espera</h2>
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
                                <a class="btn btn-primary btn-sm m-t-10" href="{{ route('serbinario.fila.create')  }}">Adicionar à Fila</a>
                            </div>
                        </div>
                    </div>
                    <!-- Botão novo -->

                    <div class="row" >
                        <br />
                        {!! Form::open(['method' => "POST"]) !!}
                        <div class="col-md-12">

                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    <?php $data = new \DateTime('now') ?>
                                    {!! Form::label('data_inicio', 'Início') !!}
                                    {!! Form::text('data_inicio', null , array('class' => 'form-control dateTimePicker date', 'placeholder' => 'Data inicial')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    {!! Form::label('data_fim', 'Fim') !!}
                                    {!! Form::text('data_fim', null , array('class' => 'form-control dateTimePicker date', 'placeholder' => 'Data final')) !!}
                                </div>
                            </div>

                            <div class="form-group col-sm-2">
                                <div class=" fg-line">
                                    <label for="exame">Tipo</label>
                                    <div class="select">
                                        {!! Form::select('tipo', (['' => 'Selecione um tipo'] + $loadFields['tipooperacao']->toArray()), null, array('class' => 'form-control', 'id' => 'tipo')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-sm-3">
                                <div class=" fg-line">
                                    <label for="exame">Exame</label>
                                    <div class="select">
                                        {!! Form::select('exame', array(), null, array('class' => 'form-control', 'id' => 'exame')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-sm-2">
                                <div class=" fg-line">
                                    <label for="prioridade">Prioridade</label>
                                    <div class="select">
                                        {!! Form::select('prioridade', (['' => 'Selecione'] + $loadFields['prioridade']->toArray()), null, array('id' => 'prioridade', 'class'=> 'form-control')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-sm-4">
                                <div class=" fg-line">
                                    <label for="psf">PSF</label>
                                    <div class="select">
                                        {!! Form::select('psf', (['' => 'Selecione'] + $loadFields['postosaude']->toArray()), null, array('id' => 'psf', 'class'=> 'form-control')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('globalSearch', 'Pesquisar') !!}
                                    {!! Form::text('globalSearch', null , array('class' => 'form-control', 'placeholder' => 'Pesquisar...')) !!}
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <button type="submit" style="margin-top: 28px" id="search" class="btn-primary btn input-sm">Consultar</button>
                            </div>

                        </div>
                        {!! Form::close() !!}
                    </div>

                </div>

                <div class="card-body card-padding">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="text-right">
                                <a class="btn btn-success btn-sm m-t-10" href="{{ route('serbinario.agendamento.index')  }}">Agenda</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="fila-grid" class="display table table-bordered compact" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Cidadão</th>
                                <th>Especialidade</th>
                                <th>Prioridade</th>
                                <th>Data do cadastro</th>
                                <th>Número do SUS</th>
                                <th>PSF</th>
                                <th>Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Cidadão</th>
                                <th>Especialidade</th>
                                <th>Prioridade</th>
                                <th>Data do cadastro</th>
                                <th>Número do SUS</th>
                                <th>PSF</th>
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
        var table = $('#fila-grid').DataTable({
            processing: true,
            serverSide: true,
            bFilter: false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json'
            },
            ajax: {
                url: "{!! route('serbinario.fila.grid') !!}",
                method: 'POST',
                data: function (d) {
                    d.data_inicio = $('input[name=data_inicio]').val();
                    d.data_fim = $('input[name=data_fim]').val();
                    d.exame = $('select[name=exame] option:selected').val();
                    d.prioridade = $('select[name=prioridade] option:selected').val();
                    d.psf = $('select[name=psf] option:selected').val();
                    d.globalSearch = $('input[name=globalSearch]').val();
                }
            },
            columns: [
                {data: 'nome', name: 'cgm.nome'},
                {data: 'especialidade', name: 'operacoes.nome'},
                {data: 'prioridade', name: 'prioridade.nome'},
                {data: 'data_cadastro', name: 'fila.data'},
                {data: 'numero_sus', name: 'cgm.numero_sus'},
                {data: 'psf', name: 'posto_saude.nome'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        //Função do submit do search da grid principal
        $('#search').click(function(e) {
            table.draw();
            e.preventDefault();
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

        //Carregando os bairros
        $(document).on('change', "#tipo", function () {
            //Removendo as Bairros
            $('#exame option').remove();

            //Recuperando a cidade
            var tipo = $(this).val();

            if (tipo !== "") {
                var dados = {
                    'table' : 'grupo_operacoes',
                    'field_search' : 'tipo_operacoes.id',
                    'value_search': tipo,
                    'tipo_search': "2"
                };

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('serbinario.util.searchOperacoes')  }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
                    },
                    data: dados,
                    datatype: 'json'
                }).done(function (json) {
                    var option = "";

                    for (var i = 0; i < json.length; i++) {
                        option += '<optgroup label="' + json[i]['text'] + '">';
                        for (var j = 0; j < json[i]['children'].length; j++) {
                            option += '<option value="' + json[i]['children'][j]['id'] + '">'+json[i]['children'][j]['text']+'</option>';
                        }
                        option += '</optgroup >';
                    }

                    $('#exame optgroup').remove();
                    $('#exame').append(option);
                });
            }
        });
    </script>
@stop
