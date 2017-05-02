<div class="row">
	<div class="col-md-12">
		<div class="row">

            {{--<div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('nome', 'nome') !!}
				{!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                </div>
            </div>--}}
			<div class="col-md-2">
				<div class="form-group">
					{!! Form::label('tipo', 'Tipo ') !!}
					@if(isset($model->operacao->grupo->tipo->id))
						{!! Form::select('tipo', $loadFields['tipooperacao'], $model->operacao->grupo->tipo->id, array('class' => 'form-control', 'id' => 'tipo')) !!}
					@else
						{!! Form::select('tipo', (['' => 'Selecione um tipo'] + $loadFields['tipooperacao']->toArray()), null, array('class' => 'form-control', 'id' => 'tipo')) !!}
					@endif
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('operacao_id', 'Operação ') !!}
					@if(isset($model->operacao->id))
						{!! Form::select('operacao_id', array($model->operacao->id => $model->operacao->nome), $model->operacao->id,array('class' => 'form-control', 'id' => 'operacao_id')) !!}
					@else
						{!! Form::select('operacao_id', array(), Session::getOldInput('operacao_id'),array('class' => 'form-control', 'id' => 'operacao_id')) !!}
					@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="form-group">
					{!! Form::label('preparo', 'Preparo') !!}
					{!! Form::textarea('preparo', Session::getOldInput('preparo')  ,['size' => '90x5'] , array('class' => 'form-control')) !!}
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="btn-group btn-group-justified">
			<div class="btn-group">
				<a href="{{ route('serbinario.especialidade.index') }}" class="btn btn-primary btn-block"><i
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
		//Carregando as operações
		/*$("#ddd").select2({
			placeholder: 'Selecione uma operação',
			minimumInputLength: 3,
			width: 400,
			ajax: {
				type: 'POST',
				url: "",
				dataType: 'json',
				delay: 250,
				crossDomain: true,
				data: function (params) {
					return {
						'search':     params.term, // search term
						'tableName':  'grupo_operacoes',
						'fieldName':  'nome',
						/!*'fieldWhere':  'nivel',
						 'valueWhere':  '3',*!/
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
		});*/

		//Carregando os bairros
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
					'tipo_search': "1"
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

					$('#operacao_id optgroup').remove();
					$('#operacao_id').append(option);
				});
			}
		});
	</script>
@stop