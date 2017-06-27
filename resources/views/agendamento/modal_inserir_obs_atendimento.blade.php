<!-- Modal de cadastro das Disciplinas-->
<div id="modal-inserir-obs-atendimento" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog" style="width: 30%">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Insira uma observação</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">

                <div class="row" style="margin-top: 2%;">

                    <!-- Gerendiamento das Especialidades -->
                    <div class="col-md-12">
                        <!-- Adicionar Especialidades -->
                        <div class="row" style="margin-top: -2%; margin-bottom: 3%;">
                            <div class="form-group col-md-12">
                                <div class=" fg-line">
                                    <label for="preparo">Observaçâo</label>
                                    {!! Form::textarea('observacao', Session::getOldInput('observacao'),
                                        array('class' => 'form-control input-sm', 'id' => 'observacao', 'rows' => '4', 'placeholder' => 'Adicione uma observação')) !!}
                                </div>
                            </div>

                            <div class="form-group col-md-5">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <button type="button" id="salvarObservacao" class="btn btn-primary btn-sm m-t-10">Salvar observação</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <button type="button" id="inserirNaFila" class="btn btn-success btn-sm m-t-10">Inserir na fila</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fim Adicionar Especialidades -->
                    </div>
                    <!-- Fim do Gerendiamento das Especialidades -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Especialidades-->
