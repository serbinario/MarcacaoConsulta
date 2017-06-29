<div class="block-header">
	<h2>Cadastro de Suboperações</h2>
</div>

<div class="card">
	<div class="card-body card-padding">
		<div class="row">

			<div class="form-group col-sm-3">
				<div class="fg-line">
					<label class="control-label" for="operacao_id">Operação *</label>
					{!! Form::select('operacao_id', (['' => 'Selecione uma operação'] + $loadFields['operacoe']->toArray()), null, array('class' => 'form-control imput-sm')) !!}
				</div>
			</div>
			<div class="form-group col-md-3">
				<div class="fg-line">
					{!! Form::label('nome', 'Nome *') !!}
					{!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control input-sm')) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<button type="submit" class="btn btn-primary btn-sm m-t-10">Salvar</button>
				<a class="btn btn-primary btn-sm m-t-10" href="{{ route('serbinario.suboperacao.index') }}">Voltar</a>
			</div>
		</div>

	</div>
</div>
@section('javascript')
	<script src="{{ asset('/js/validacoes/validation_form_operacao.js')}}"></script>
@stop