<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="form-group col-md-5">
                <label for="cgm">CGM</label>
                <select id="cgm" class="form-control" name="cgm">
                    @if(isset($model->id) && $model->getCgm != null)
                        <option value="{{ $model->getCgm->id  }}" selected="selected">{{ $model->getCgm->nome }}</option>
                    @endif
                </select>
            </div>
            <div class="col-md-2">
                <div class="form-group">
				{!! Form::label('qtd_vagas', 'Quantidade de vagas') !!}
				{!! Form::text('qtd_vagas', Session::getOldInput('qtd_vagas')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('crm', 'CRM') !!}
                    {!! Form::text('crm', Session::getOldInput('crm')  , array('class' => 'form-control')) !!}
                </div>
            </div>
		</div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('tipo', 'Tipo ') !!}
                    {!! Form::select('tipo', (['' => 'Selecione um tipo'] + $loadFields['tipooperacao']->toArray()), null, array('class' => 'form-control', 'id' => 'tipo')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('operacao_id', 'Operação ') !!}
                    {!! Form::select('operacao_id', array(), Session::getOldInput('operacao_id'),array('class' => 'form-control', 'id' => 'operacao_id')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <button type="button" id="btnAdd" style="margin-top: 22px;" class="btn btn-primary btn-sm">Adicionar</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <table id="especialidades" class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 24%">Tipo</th>
                        <th>Especialidade</th>
                        <th style="width: 10%">Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(isset($model->id))
                            @foreach($model->especialistaEspecialidade as $especialidade)
                                <tr>
                                    <td>{{$especialidade->operacao->grupo->tipo->nome}}</td>
                                    <td>{{$especialidade->operacao->nome}}</td>
                                    <td>
                                        <button type='button' class='btn-floating remove' onclick='RemoveTableRow(this)'  title='Deletar'><i class='fa fa-times'></i></button></li>
                                        <input type='hidden' name='operacoes[]' value='{{$especialidade->id}}'>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
	</div>
    <div class="col-md-3">
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                <a href="{{ route('serbinario.especialista.index') }}" class="btn btn-primary btn-block"><i
                            class="fa fa-long-arrow-left"></i> Voltar</a></div>
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
            </div>
        </div>
    </div>
</div>
@section('javascript')
    <script src="{{ asset('/js/validacoes/validation_form_aluno.js')}}"></script>
    <script type="text/javascript">
        //consulta via select2 cgm
        $("#cgm").select2({
            placeholder: 'Selecione um cgm',
            minimumInputLength: 3,
            width: 400,
            ajax: {
                type: 'POST',
                url: "{{ route('serbinario.util.select2')  }}",
                dataType: 'json',
                delay: 250,
                crossDomain: true,
                data: function (params) {
                    return {
                        'search':     params.term, // search term
                        'tableName':  'cgm',
                        'fieldName':  'nome',
                        /*'fieldWhere':  'nivel',
                         'valueWhere':  '3',*/
                        'page':       params.page
                    };
                },
                headers: {
                    'X-CSRF-TOKEN' : '{{  csrf_token() }}'
                },
                processResults: function (data, params) {

                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                }
            }
        });

        //Carregando as especialidades
        $(document).on('change', "#tipo", function () {
            //Removendo as Bairros
            $('#operacao_id option').remove();

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

                    for ( var i = 0; i < json.length; i++) {
                        option += '<optgroup label="' + json[i]['text'] + '">';
                        for (var j = 0; j < json[i]['children'].length; j++) {
                            option += '<option value="' + json[i]['children'][j]['id'] + '">'+json[i]['children'][j]['text']+'</option>';
                        }
                        option += '</optgroup >';
                    }

                    $('#operacao_id optgroup').remove();
                    $('#operacao_id').append(option);
                });
            }
        });

        //Carregando as especialidades
        $(document).on('click', "#btnAdd", function () {

            //Recuperando a cidade
            var operacaoId = $('select[name=operacao_id] option:selected').val();
            var operacaoNome = $('select[name=operacao_id] option:selected').text();
            var tipo = $('select[name=tipo] option:selected').text();

            var html = "";

            html += '<tr>';
            html += '<td>' + tipo + '</td>';
            html += '<td>' + operacaoNome + '</td>';
            html += "<td>" +
                    "<button type='button' class='btn-floating remove' onclick='RemoveTableRow(this)'  title='Deletar'><i class='fa fa-times'></i></button></li></td>" +
                    "<input type='hidden' name='operacoes[]' value='" + operacaoId + "'>";
            html += '</tr>';

            $('#especialidades tbody').append(html);

        });

        //Excluir tr da tabela
        (function ($) {
            RemoveTableRow = function (handler) {
                var tr = $(handler).closest('tr');

                tr.fadeOut(400, function () {
                    tr.remove();
                });
                return false;
            };
        })(jQuery);
    </script>
@stop