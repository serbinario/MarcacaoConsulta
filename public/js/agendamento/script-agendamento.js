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
            'hora': $('#hora').val(),
            'dataEvento' : $('#data').val()
        };

        $.ajax({
            url: "/index.php/serbinario/agendamento/store",
            data: {dados: dados},
            dataType: "json",
            type: "POST",
            success: function (data) {
                alert(data['msg']);
                $("#calendar").fullCalendar("refetchEvents");
                paciente("", especialidade);
                $("#modalCGM").modal('hide');

            }
        });
    });

    //editar formul�rio da marca��o de consulta
    /*$("#edit").click(function (event) {
        event.preventDefault();

        var especialidade = $('#grupo_operacao').val();

        var dados = {
            'fila_id': $('#paciente').val(),
            'calendario_id': $('#calendario').val(),
            'posto_saude_id': $('#psf').val(),
            'obs': $('#obs').val(),
            'status': '1',
            'hora': $('#hora').val()
        };

        jQuery.ajax({
            type: 'POST',
            url: laroute.route('serbinario.agendamento.update', {'id' : $('#id').val()}),
            data: {dados: dados},
            datatype: 'json'
        }).done(function (retorno) {
            alert(retorno['msg']);
            $("#calendar").fullCalendar("refetchEvents");
            $("#modalCGM").modal('hide');
        });
    });*/

    //deletar formul�rio da marca��o de consulta
    $("#delete").click(function (event) {
        event.preventDefault();

        var especialidade = $('#grupo_operacao').val();

        jQuery.ajax({
            type: 'POST',
            url: "/index.php/serbinario/agendamento/delete/"+$('#id').val(),
            datatype: 'json'
        }).done(function (retorno) {
            alert(retorno['msg']);
            $("#calendar").fullCalendar("refetchEvents");
            paciente("", especialidade);
            $("#modalCGM").modal('hide');
        });
    });

});
