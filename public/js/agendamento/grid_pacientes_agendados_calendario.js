/**
 * Created by Fabio on 30/05/2017.
 */

// Carregaando a grid
table = $('#agendados-grid').DataTable({
    retrieve: true,
    processing: true,
    serverSide: true,
    iDisplayLength: 25,
    bLengthChange: false,
    bFilter: false,
    autoWidth: false,
    ajax: {
        url: "/serbinario/agendados/grid",
        method: 'POST',
        data: function (d) {
            d.data_inicio       = "";
            d.data_fim          = "";
            d.data_unica        = $('input[name=data]').val();
            d.especialidade     = $('select[name=grupo_operacao] option:selected').val();
            d.especialista      = $('select[name=especialista] option:selected').val();
            d.localidade        = $('select[name=localidade] option:selected').val();
        }
    },
    columns: [
        {data: 'nome', name: 'cgm.nome'},
        {data: 'numero_sus', name: 'cgm.numero_sus'},
        {data: 'sub_operacao', name: 'sub_operacoes.nome'},
        //{data: 'data', name: 'calendario.data'},
        {data: 'horario', name: 'mapas.horario'},
        //{data: 'especialista', name: 'cgm_especialista.nome'},
        {data: 'psf', name: 'posto_saude.nome'},
        {data: 'status', name: 'status_agendamento.nome'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
});

// Selecionar as tr da grid
$(document).on('click', '#agendados-grid tbody tr', function () {
    // Aplicando o estilo css
    if ($(this).hasClass("selected")) {
        $(this).removeClass("selected");
    } else {
        $(this).addClass("selected");
    }
});

// Evento para quando clicar na tr da table de pacientes
$(document).on('click', '#agendados-grid tbody tr', function () {

    // Array que armazenará os ids dos pacientes
    var aux;
    var auxHabilitarBotaoReagendar;
    var arrayId = [];

    // Varrendo as linhas
    $("#agendados-grid tbody tr.selected").each(function (index, value) {

        arrayId[index] = table.row($(value).index()).data().id;

        //Validando e pegando os paciente do mesmo exame
        if(arrayId.length == 1) {

            especialidadeId = table.row($(value).index()).data().exame; //Pegando o id da especialidade
            aux  = table.row($(value).index()).data().exame;
            auxHabilitarBotaoReagendar = true;

        } else if (arrayId.length > 1 && aux == table.row($(value).index()).data().exame) {

            especialidadeId = table.row($(value).index()).data().exame; //Pegando o id da especialidade
            aux = table.row($(value).index()).data().exame;
            auxHabilitarBotaoReagendar = true;

        } else if (arrayId.length > 1 && aux != table.row($(value).index()).data().exame) {
            auxHabilitarBotaoReagendar = false;
            swal("Oops...", "Pacientes com exames diferentes. Selecione pacientes com o mesmo exame!", "error");
            return false;
        }

    });

    // Habilitando e desabilitando o botão de reagendamento
    if(arrayId.length > 0 && auxHabilitarBotaoReagendar) {
        $('#reagendarPaciente').prop('disabled', false);
    } else {
        $('#reagendarPaciente').prop('disabled', true);
    }

    // Habilitando e desabilitando o botão de reagendamento
    if (arrayId.length > 0) {
        $('#definirAtendimento').prop('disabled', false);
    } else {
        $('#definirAtendimento').prop('disabled', true);
    }

    // Armazenando os ids dos paciente em um array global
    idsPacientes = arrayId;

});

