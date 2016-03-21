<div class="row">
	<div class="col-md-12">
		<div class="row">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#dpessoais" aria-controls="dpessoais" role="tab" data-toggle="tab">Dados pessoais</a></li>
                <li role="presentation"><a href="#doc" aria-controls="doc" role="tab" data-toggle="tab">Documentação</a></li>
                <li role="presentation"><a href="#end" aria-controls="end" role="tab" data-toggle="tab">Endereço</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="dpessoais">
                    <br />
                    <div class="col-md-10">
                        <div class="form-group">
                            {!! Form::label('nome', 'Nome') !!}
                            {!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('sexo', 'Sexo') !!}
                            {!! Form::select('sexo', $loadFields['sexo'], Session::getOldInput('sexo'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('estado_civil', 'Estado Civil') !!}
                            {!! Form::select('estado_civil', $loadFields['estadocivil'], Session::getOldInput('estado_civil'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('data_nascimento', 'Data Nascimento') !!}
                            {!! Form::text('data_nascimento', null, array('class' => 'form-control datepicker')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('data_falecimento', 'Data Falecimento') !!}
                            {!! Form::text('data_falecimento', null, array('class' => 'form-control datepicker')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('nacionalidade', 'Nacionalidade') !!}
                            {!! Form::select('nacionalidade', $loadFields['nacionalidade'], Session::getOldInput('nacionalidade'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('naturalidade', 'Naturalidade') !!}
                            {!! Form::text('naturalidade', Session::getOldInput('naturalidade')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('pai', 'Nome do pai') !!}
                            {!! Form::text('pai', Session::getOldInput('pai')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('mae', 'Nome da Mãe') !!}
                            {!! Form::text('mae', Session::getOldInput('mae')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('escolaridade', 'Escolaridade') !!}
                            {!! Form::select('escolaridade', $loadFields['escolaridade'], Session::getOldInput('escolaridade'), array('class' => 'form-control')) !!}
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('cgmmunicipio', 'CGM do município?') !!}
                            {!! Form::select('cgmmunicipio', $loadFields['cgmmunicipio'], Session::getOldInput('cgmmunicipio'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('email', 'E-mail') !!}
                            {!! Form::text('email', Session::getOldInput('email')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>

                </div>
                <div role="tabpanel" class="tab-pane" id="doc">
                    <br />
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('cpf_cnpj', 'CPF') !!}
                                    {!! Form::text('cpf_cnpj', Session::getOldInput('cpf_cnpj')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('rg', 'RG') !!}
                                    {!! Form::text('rg', Session::getOldInput('rg')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('orgao_emissor', 'Orgão Emissor') !!}
                                    {!! Form::text('orgao_emissor', Session::getOldInput('orgao_emissor')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('data_expedicao', 'Data Expedição') !!}
                                    {!! Form::text('data_expedicao', null, array('class' => 'form-control datepicker')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('numero_sus', 'Número do SUS') !!}
                                    {!! Form::text('numero_sus', Session::getOldInput('numero_sus')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('numero_nis', 'Número NIS') !!}
                                    {!! Form::text('numero_nis', Session::getOldInput('numero_nis')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('num_cnh', 'Número CNH') !!}
                                    {!! Form::text('num_cnh', Session::getOldInput('num_cnh')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('venci_cnh', 'Vencimento CNH') !!}
                                    {!! Form::text('venci_cnh', null, array('class' => 'form-control datepicker')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('categoria_cnh', 'Categoria CNH') !!}
                                    {!! Form::select('categoria_cnh', $loadFields['categoriacnh'], Session::getOldInput('categoria_cnh'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('nire', 'Nire') !!}
                                    {!! Form::text('nire', Session::getOldInput('nire')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('numero_titulo', 'Nmero do Título') !!}
                                    {!! Form::text('numero_titulo', Session::getOldInput('numero_titulo')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('numero_zona', 'Zona') !!}
                                    {!! Form::text('numero_zona', Session::getOldInput('numero_zona')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('numero_sessao', 'Sessão') !!}
                                    {!! Form::text('numero_sessao', Session::getOldInput('numero_sessao')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="end">
                    <br />
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::label('logradouro', 'Logradouro') !!}
                            {!! Form::text('endereco[logradouro]', Session::getOldInput('endereco[logradouro]')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            {!! Form::label('end_numero', 'Número') !!}
                            {!! Form::text('endereco[numero]', Session::getOldInput('endereco[numero]')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            {!! Form::label('comp', 'Comple.') !!}
                            {!! Form::text('endereco[comp]', Session::getOldInput('endereco[comp]')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('cep', 'CEP') !!}
                            {!! Form::text('endereco[cep]', Session::getOldInput('endereco[cep]')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('estado', 'Estado') !!}
                            {!! Form::select('estado', $loadFields['estado'], array(), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('cidade', 'Cidade') !!}
                            {!! Form::select('cidade', array(), array(), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('endereco', 'Bairro') !!}
                            {!! Form::select('endereco[bairro]', array(), array(), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
    <div class="col-md-2">
        {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block pull-right')) !!}
    </div>
</div>