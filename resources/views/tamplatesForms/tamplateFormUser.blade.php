<div class="block-header">
	<h2>Cadastro de Usuários</h2>
</div>

<div class="card">
	<div class="card-body card-padding">
		<!-- Nav tabs -->
		<ul class="tab-nav" role="tablist">
			<li><a href="#user" aria-controls="user" role="tab" data-toggle="tab">Dados Gerais</a>
			</li>

			<li><a href="#permission" aria-controls="permission" role="tab" data-toggle="tab">Permissões</a>
			</li>

			<li><a href="#perfil" aria-controls="perfil" role="tab" data-toggle="tab">Perfís</a>
			</li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">

			{{-- - --}}
			<div role="tabpanel" class="tab-pane active" id="user">
				<br/>
				<div class="row">
					<div class="form-group col-sm-4">
						<div class="fg-line">
							<label class="control-label" for="nome">Nome</label>
							{!! Form::text('nome', Session::getOldInput('nome') , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
						</div>
					</div>
					<div class="form-group col-md-offset-2 col-sm-4">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<div style="position:absolute; top:-30px; left:266px;" class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
							<div>
										<span style="position:absolute; top:130px; left:266px;" class="btn btn-info btn-file">
											<span class="fileinput-new">Enviar arquivo</span>
											{{--<span class="fileinput-exists">Change</span>--}}
											{{--<input type="file" name="...">--}}
										</span>
								{{--<a href="#" class="btn btn-danger fileinput-exists"
								   data-dismiss="fileinput">Remove</a>--}}
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-4">
						<div class="fg-line">
							<label class="control-label" for="email">Email</label>
							{!! Form::text('email', Session::getOldInput('email') , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-2">
						<div class="fg-line">
							<label for="password">Senha</label>
							{!! Form::password('password', array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-2">
						<label for="status" class="checkbox checkbox-inline m-r-20">
							{!! Form::hidden('active', 0) !!}
							{!! Form::checkbox('active', 1, null, Array()) !!}
							<i class="input-helper"></i>
							Ativo
						</label>
					</div>
				</div>

				{{--<div class="col-md-4">
					<div class="fileinput fileinput-new" data-provides="fileinput">
						<div class="fileinput-preview thumbnail" data-trigger="fileinput"
							 style="width: 135px; height: 115px;">
						</div>
						<div>
                                        <span class="btn btn-primary btn-xs btn-block btn-file">
                                            <span class="fileinput-new">Selecionar</span>
                                            <span class="fileinput-exists">Mudar</span>
                                            <input type="file" name="img">
                                        </span>
							--}}{{--<a href="#" class="btn btn-warning btn-xs fileinput-exists col-md-6" data-dismiss="fileinput">Remover</a>--}}{{--
						</div>
					</div>
				</div>--}}
			</div>

			{{-- - --}}
			<div role="tabpanel" class="tab-pane" id="permission">
				<br/>
				<div id="tree-role">
					<ul>
						<li>
							<input type="checkbox"> Todos
							<ul>
								@if(isset($loadFields['permission']))
									@foreach($loadFields['permission'] as $id => $permission)
										<li><input type="checkbox" name="permission[]" value="{{ $id  }}"> {{ $permission }} </li>
									@endforeach
								@endif
							</ul>
						</li>
					</ul>
				</div>
			</div>

			{{-- - --}}
			<div role="tabpanel" class="tab-pane" id="perfil">
				<br/>
				<div id="tree-permission">
					<ul>
						@if(isset($loadFields['role']))
							@foreach($loadFields['role'] as $id => $role)
								<li><input type="checkbox" name="role[]" value="{{ $id  }}"> {{ $role }} </li>
							@endforeach
						@endif
					</ul>
				</div>
			</div>
		</div>
		<button class="btn btn-primary btn-sm m-t-10">Salvar</button>
	</div>
</div>
