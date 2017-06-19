<!-- Modal de cadastro das Disciplinas-->
<div id="modal-reagendamento" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Reagendar Pacientes</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row" style="margin-bottom: 5%;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12" style="background-color: #e6e9dc">
                                <div class="col-md-4" style="margin-top: 17px">
                                    <span><strong>Do especialista: </strong><p class="Nome"></p></span>
                                </div>

                                <div class="col-md-2" style="margin-top: 17px">
                                    <span><strong>De CRM: </strong><p class="CRM"></p></span>
                                </div>
                                <div class="col-md-4" style="margin-top: 17px">
                                    <span><strong>Pacientes a serem reagendados: </strong><p class="qtdPacientes"></p></span>
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
                                    <label for="especialista">Especialista *</label>
                                    <div class="select">
                                        {!! Form::select("especialista", array(), null, array('class'=> 'form-control', 'id' => 'especialista-modal')) !!}
                                        <input type="hidden" name="especialidade" value="" id="especialidade-reagendar">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <div class=" fg-line">
                                    <label for="calendario-reagendar">Calendário *</label>
                                    <div class="select">
                                        {!! Form::select("calendario", array(), null, array('class'=> 'form-control', 'id' => 'calendario-reagendar')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <div class=" fg-line">
                                    <label for="mapa-reagendar">Mapas *</label>
                                    <div class="select">
                                        {!! Form::select("mapa", array(), null, array('class'=> 'form-control', 'id' => 'mapa-reagendar')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <div class=" fg-line">
                                    <label for="total-vagas">Total de vagas</label>
                                    <input type="text" readonly class="form-control" id="total-vagas">
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <div class=" fg-line">
                                    <label for="vagas-restantes">Vagas restantes</label>
                                    <input type="text" readonly class="form-control" id="vagas-restantes">
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <div class="fg-line" style="margin-top: 20px">
                                    <div class="fg-line">
                                        <button type="button" id="reagendar" class="btn btn-primary btn-sm m-t-10">Reagendar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row msg">
                            <p style="color: red; margin-top: -30px">* A quantidade de vagas disponíveis no MAPA selecioando é
                                inferior a quantidade de pacientes selecionados para reagendamento.</p>
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
