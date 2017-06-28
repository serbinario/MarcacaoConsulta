<!-- Modal de cadastro das Disciplinas-->
<div id="modal-historico-atendimento" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Histórico de atendimento</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row" style="margin-bottom: 5%;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12" style="background-color: #e6e9dc">
                                <div class="col-md-4" style="margin-top: 17px">
                                    <span><strong>Paciente: </strong><p class="Nome"></p></span>
                                </div>

                                <div class="col-md-2" style="margin-top: 17px">
                                    <span><strong>Nº SUS: </strong><p class="SUS"></p></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 2%;">

                    <!-- Gerendiamento das Especialidades -->
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="histotico-atendimento-grid" class="display table table-bordered compact" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Detalhe</th>
                                    <th>Especialidade</th>
                                    <th>Data</th>
                                    <th>Prioridade</th>
                                    <th>Posto de saúde</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Detalhe</th>
                                    <th>Especialidade</th>
                                    <th>Data</th>
                                    <th>Prioridade</th>
                                    <th>Posto de saúde</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- Fim do Gerendiamento das Especialidades -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Especialidades-->
