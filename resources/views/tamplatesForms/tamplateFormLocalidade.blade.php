<div class="block-header">
	<h2>Cadastrar de Localidade</h2>
</div>

<div class="card">
	<div class="card-body card-padding">
		{{--#1--}}
		<div class="row">
			<div class="form-group col-md-4">
				<div class="input-sm">
					{!! Form::label('nome', 'nome') !!}
					{!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
				</div>
			</div>
		</div>
		{{--#2--}}

		<br />
		<button type="submit" class="btn btn-primary btn-sm m-t-10">Salvar</button>
		<a class="btn btn-primary btn-sm m-t-10" href="{{ route('serbinario.localidade.index') }}">Voltar</a>
	</div>
</div>
@section('javascript')
	<script src="{{ asset('/js/validacoes/validation_form_unidade.js')}}"></script>
@stop