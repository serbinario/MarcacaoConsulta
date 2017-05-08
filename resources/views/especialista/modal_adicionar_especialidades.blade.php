<!-- Modal de cadastro das Disciplinas-->
<div id="modal-adicionar-especialidades" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Adicionar Especialidades</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row" style="margin-bottom: 5%;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12" style="background-color: #e6e9dc">
                                <div class="col-md-4" style="margin-top: 17px">
                                    <span><strong>Especialista: </strong><p class="Nome"></p></span>
                                </div>

                                <div class="col-md-2" style="margin-top: 17px">
                                    <span><strong>CRM: </strong><p class="CRM"></p></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row" style="margin-top: 2%;">

                    <!-- Gerendiamento das Especialidades -->
                    <div class="col-md-12">
                        <!-- Adicionar Especialidades -->
                        <div class="row" style="margin-top: -2%; margin-bottom: 3%;">
                            <div class="form-group col-md-2">
                                <div class=" fg-line">
                                    <label for="tipo_operacao">Tipo operação *</label>
                                    <div class="select">
                                        {!! Form::select("tipo_operacao", array(), null, array('class'=> 'form-control', 'id' => 'tipoOperacao')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class=" fg-line">
                                    <label for="especialidade">Especialidade *</label>
                                    <div class="select">
                                        {!! Form::select("especialidade", array(), null, array('class'=> 'form-control', 'id' => 'especialidade')) !!}
                                    </div>
                                </div>
                            </div>


                            <div class="form-group col-md-2">
                                <div class="fg-line" style="margin-top: 20px">
                                    <div class="fg-line">
                                        <button type="button" id="addEspecialidade" class="btn btn-primary btn-sm m-t-10">Adicionar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fim Adicionar Especialidades -->

                        <!-- Table de Especialidades -->
                        <div class="table-responsive">
                            <table id="especialidades-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Especialidade</th>
                                    <th style="width: 8%;">Acão</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- Fim Table de telefones -->
                    </div>
                    <!-- Fim do Gerendiamento das Especialidades -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Especialidades-->
