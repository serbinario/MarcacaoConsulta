/**
 * Created by Fabio on 30/05/2017.
 */

var tableCalendario, perfil;

function loadTableCalendario (idEspecialista) {
    // Carregaando a grid
    tableCalendario = $('#grid-calendario-especialista').DataTable({
        retrieve: true,
        processing: true,
        serverSide: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        "order": [[ 6, "asc" ]],
        ajax: {
            url: "/serbinario/calendario/gridCalendario/"+idEspecialista,
            method: 'POST',
            data: function (d) {
                d.data_inicio = $('input[name=data_inicio]').val();
                d.data_fim = $('input[name=data_fim]').val();
                d.especialidade = $('select[name=especialidade-grid] option:selected').val();
                d.status = $('select[name=status] option:selected').val();
            }
        },
        columns: [
            {data: 'data', name: 'calendario.data'},
            {data: 'localidade', name: 'localidade.nome'},
            {data: 'mapas', name: 'mapas', orderable: false, searchable: false},
            {data: 'especialidades', name: 'especialidades', orderable: false, searchable: false},
            {data: 'agendamentos', name: 'agendamentos', orderable: false, searchable: false},
            {data: 'vagas', name: 'vagas', orderable: false, searchable: false},
            {data: 'status', name: 'status.nome', orderable: true},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    //Função do submit do search da grid principal
    $('#search').click(function(e) {
        tableCalendario.draw();
        e.preventDefault();
    });

}