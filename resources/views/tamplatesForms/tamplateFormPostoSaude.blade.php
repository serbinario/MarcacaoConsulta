<div class="block-header">
	<h2>Cadastrar PSF</h2>
</div>

<div class="card">
	<div class="card-body card-padding">
		{{--#1--}}
		<div class="row">
			<div class="form-group col-sm-4">
				<div class="fg-line">
					<label class="control-label" for="nome">Nome</label>
					{!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
				</div>
			</div>
			<div class="form-group col-sm-2">
				<div class="fg-line">
					<label class="control-label" for="cnes">CNES</label>
					{!! Form::text('cnes', Session::getOldInput('cnes')  , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
				</div>
			</div>
			<div class="form-group col-sm-4">
				<div class="fg-line">
					<label class="control-label" for="endereco">Endereço</label>
					{!! Form::text('endereco', Session::getOldInput('endereco')  , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
				</div>
			</div>

			{{-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx --}}


		</div>
		{{--#2--}}
		<div class="row">
			<div class="form-group col-sm-2">
				<div class="fg-line">
					<label class="control-label" for="numero">Número</label>
					{!! Form::text('numero', Session::getOldInput('numero')  , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
				</div>
			</div>
			<div class="form-group col-sm-4">
				<div class="fg-line">
					<label class="control-label" for="bairro">Bairro</label>
					{!! Form::text('bairro', Session::getOldInput('endereco')  , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
				</div>
			</div>
		</div>

	<button class="btn btn-primary btn-sm m-t-10">Salvar</button>
	<a class="btn btn-primary btn-sm m-t-10" href="{{ route('serbinario.ps.index') }}">Voltar</a>
</div>
</div>