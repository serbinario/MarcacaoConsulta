/**
 * Created by Fabio on 30/05/2017.
 */

// Variáveis globais
var tablePacientes, especialidadeId, idsPacientes, especialistaNome, CRM;
var totalVagas, vagasRestantes;

function loadTablePaciente (idCalendario) {
    // Carregaando a grid
    tablePacientes = $('#pacientes-grid').DataTable({
        retrieve: true,
        processing: true,
        serverSide: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/serbinario/calendario/gridPacientes/"+idCalendario,
        columns: [
            {data: 'nome', name: 'cgm.nome'},
            {data: 'hora', name: 'agendamento.hora'},
            {data: 'exame', name: 'exame', orderable: false, searchable: false},
            {data: 'status', name: 'status_agendamento.nome', orderable: false, searchable: false},
            /*{data: 'action', name: 'action', orderable: false, searchable: false}*/
        ]
    });

    // Selecionar as tr da grid
    $(document).on('click', '#pacientes-grid tbody tr', function () {
        // Aplicando o estilo css
        if($(this).hasClass("selected")) {
            $(this).removeClass("selected");
        } else {
            $(this).addClass("selected");
        }
    });

    // Evento para quando clicar na tr da table de pacientes
    $(document).on('click', '#pacientes-grid tbody tr', function () {

        // Array que armazenará os ids dos pacientes
        var arrayId   = [];
        var aux;

        // Varrendo as linhas
        $("#pacientes-grid tbody tr.selected").each(function (index, value) {

            arrayId[index] = tablePacientes.row($(value).index()).data().agendamento_id;
            especialistaNome = tablePacientes.row($(value).index()).data().especialista;
            CRM = tablePacientes.row($(value).index()).data().crm;

            // Validando e pegando os paciente do mesmo exame
            if(arrayId.length == 1) {
                especialidadeId = tablePacientes.row($(value).index()).data().exame_id; // Pegando o id da especialidade
                aux  = tablePacientes.row($(value).index()).data().exame_id;
            } else if (arrayId.length > 1 && aux == tablePacientes.row($(value).index()).data().exame_id) {
                especialidadeId = tablePacientes.row($(value).index()).data().exame_id; // Pegando o id da especialidade
                aux = tablePacientes.row($(value).index()).data().exame_id;
            } else if (arrayId.length > 1 && aux != tablePacientes.row($(value).index()).data().exame_id) {
                swal("Oops...", "Você selecionou paciente com exames diferentes. Selecione paciente com o mesmo exame!", "error");
                return false;
            }

        });

        // Habilitando e desabilitando o botão de reagendamento
        if(arrayId.length > 0) {
            $('#reagendarPaciente').prop('disabled', false);
        } else {
            $('#reagendarPaciente').prop('disabled', true);
        }

        // Armazenando os ids dos paciente em um array global
        idsPacientes = arrayId;

        console.log(idsPacientes);

    });

    return tablePacientes;
}


// Função de execução
function runModalAdicionarPacientes(idCalendario)
{
    //Carregando as grids de situações
    if(tablePacientes) {
        loadTablePaciente(idCalendario).ajax.url("/serbinario/calendario/gridPacientes/"+idCalendario).load();
    } else {
        loadTablePaciente(idCalendario);
    }
}