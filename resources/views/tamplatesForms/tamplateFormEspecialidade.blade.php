<div class="block-header">
	<h2>Cadastro de Especialidade</h2>
</div>

<div class="card">
	<div class="card-body card-padding">
		<div class="row">

			<div class="form-group col-sm-3">
				<div class="fg-line">
					<label class="control-label" for="tipo">Tipo *</label>
					@if(isset($model->operacao->grupo->tipo->id))
						{!! Form::select('tipo', $loadFields['tipooperacao'], $model->operacao->grupo->tipo->id, array('class' => 'form-control imput-sm', 'id' => 'tipo')) !!}
					@else
						{!! Form::select('tipo', (['' => 'Selecione um tipo'] + $loadFields['tipooperacao']->toArray()), null, array('class' => 'form-control imput-sm', 'id' => 'tipo')) !!}
					@endif
				</div>
			</div>
			<div class="form-group col-sm-3">
				<div class="fg-line">
					<label class="control-label" for="operacao_id">Operação *</label>
					<div class="select">
						@if(isset($model->operacao->id))
							{!! Form::select('operacao_id', array($model->operacao->id => $model->operacao->nome), $model->operacao->id,array('class' => 'form-control', 'id' => 'operacao_id')) !!}
						@else
							{!! Form::select('operacao_id', array(), Session::getOldInput('operacao_id'),array('class' => 'form-control', 'id' => 'operacao_id')) !!}
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="form-group">
					<div class=" fg-line">
						<label for="preparo">Preparo</label>
						{!! Form::textarea('preparo', Session::getOldInput('preparo'),
                            array('class' => 'form-control input-sm', 'placeholder' => 'Adicione uma observação')) !!}
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<button type="submit" class="btn btn-primary btn-sm m-t-10">Salvar</button>
				<a class="btn btn-primary btn-sm m-t-10" href="{{ route('serbinario.especialidade.index') }}">Voltar</a>
			</div>
		</div>

	</div>
</div>
@section('javascript')
	<script src="{{ asset('/js/validacoes/validation_form_especialidade.js')}}"></script>
	<script type="text/javascript">

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
					url: '/index.php/serbinario/util/searchOperacoes',
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