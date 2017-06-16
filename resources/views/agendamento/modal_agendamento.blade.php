<div id="modal-agendamento" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h3 class="modal-title">Agendar Paciente</h3><br />
                <div id="modal-cabecalho">
                </div>
            </div>
            <form method="post" id="form_agendamento">
                <div class="modal-body" style="alignment-baseline: central">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control" name="cgm_id" id="paciente">
                                    </select>
                                    <input type="hidden" id="calendario" name="calendario_id">
                                    <input type="hidden" id="data" name="data">
                                    <input type="hidden" id="id" name="id">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <select class="form-control" name="hora" id="hora">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="obs">Observação</label>
                                <div class="form-group">
                                    <textarea name="obs" id="obs" rows="4" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" disabled id="save">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>