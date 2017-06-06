<!-- Modal de cadastro das Disciplinas-->
<div id="modal-definir-atendimento" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog" style="width: 30%">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Selecione a situação</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">

                <div class="row" style="margin-top: 2%;">

                    <!-- Gerendiamento das Especialidades -->
                    <div class="col-md-12">
                        <!-- Adicionar Especialidades -->
                        <div class="row" style="margin-top: -2%; margin-bottom: 3%;">

                            <div class="form-group col-md-12">
                                <div class=" fg-line">
                                    <select class="form-control" name="definir-situacao" id="definir-situacao">
                                        @foreach($situacoes as $situacao)
                                            @if($situacao->id == 3 || $situacao->id == 4)
                                                <option value="{{$situacao->id}}">{{$situacao->nome}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <button type="button" id="alterarSituacao" class="btn btn-primary btn-sm m-t-10">Alterar Situação</button>
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
