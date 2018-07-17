/**
 * Created by Fabio Aguiar on 28/04/2017.
 */
//Ações do formulário
$(document).ready(function () {
    //Salvar formulário da marcação de consulta
    $("#save").click(function (event) {

        event.preventDefault();

        var especialidade = $('#grupo_operacao').val();

        var dados = {
            'fila_id': $('#paciente').val(),
            'calendario_id': $('#calendario').val(),
            'posto_saude_id': $('#psf').val(),
            'obs': $('#obs').val(),
            'status': '1',
            'mapa_id': $('#hora').val(),
            'dataEvento' : $('#data').val()
        };

        // Adicionando o loading da requisição
        $('body').addClass("loading");

        $.ajax({
            url: "/index.php/serbinario/agendamento/store",
            data: {dados: dados},
            dataType: "json",
            type: "POST",
            success: function (data) {

                // Removendo o loading da requisição
                $('body').removeClass("loading");

                swal("Paciente agendado com sucesso!", "Click no botão abaixo!", "success");
                $("#calendar").fullCalendar("refetchEvents");
                paciente("", especialidade);
                $("#modal-agendamento").modal('hide');
            }
        });
    });

    //deletar formulário da marcação de consulta
    $("#delete").click(function (event) {
        event.preventDefault();

        swal({
            title: "Alerta",
            text: "Tem certeza que deseja deletar?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Sim!"
        }).then(function () {

            var especialidade = $('#grupo_operacao').val();

            // Adicionando o loading da requisição
            $('body').addClass("loading");

            jQuery.ajax({
                type: 'POST',
                url: "/index.php/serbinario/agendamento/delete/"+ $('#id').val(),
                datatype: 'json'
            }).done(function (retorno) {

                // Removendo o loading da requisição
                $('body').removeClass("loading");

                // Valida se caso o retorno for positivo para deletar ou negativo
                if (retorno['retorno']) {
                    swal("Paciente deletado com sucesso!", "Click no botão abaixo!", "success");

                    $("#calendar").fullCalendar("refetchEvents");

                    //paciente("", especialidade);
                    $("#modal-evento-agendamento").modal('hide');
                } else {
                    swal("O paciente só poderar se deletado se estiver com situação de (aguardando atendimento)!", "Click no botão abaixo!", "error");
                }

            });

        });

    });

});
