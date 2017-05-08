// Carregando a table
var tableEspecialidades;
function loadTableEspecialidades (idEspecialista) {
    // Carregaando a grid
    tableEspecialidades = $('#especialidades-grid').DataTable({
        retrieve: true,
        processing: true,
        serverSide: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        ajax: "/serbinario/especialista/gridEspecialidades/"+idEspecialista,
        columns: [
            {data: 'tipo', name: 'tipo_operacoes.nome'},
            {data: 'especialidade', name: 'operacoes.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    return tableEspecialidades;
}


// Função de execução
function runModalAdicionarEspecialidades(idEspecialista)
{
    //Carregando as grids de situações
    if(tableEspecialidades) {
        loadTableEspecialidades(idEspecialista).ajax.url("/serbinario/especialista/gridEspecialidades/"+idEspecialista).load();
    } else {
        loadTableEspecialidades(idEspecialista);
    }
    
    // Carregando os campos selects
    tipoOperacoes("");

    // Exibindo o modal
    $('#modal-adicionar-especialidades').modal({'show' : true});
}

// Id do telefone
var idEspecialidade;

//Evento do click no botão adicionar período
$(document).on('click', '#addEspecialidade', function (event) {

    //Recuperando os valores dos campos do fomulário
    var tipoOperacao        = $('#tipoOperacao').val();
    var especialidade       = $('#especialidade').val();
    
    // Verificando se os campos de preenchimento obrigatório foram preenchidos
    if (!tipoOperacao || !especialidade) {
        swal("Oops...", "Há campos obrigatórios que não foram preenchidos!", "error");
        return false;
    }

    //Setando o o json para envio
    var dados = {
        'especialista_id' : idEspecialista,
        'especialidade_id' : especialidade
    };

    // Requisição Ajax
    jQuery.ajax({
        type: 'POST',
        url: "/serbinario/especialista/storeEspecialidade",
        data: dados,
        datatype: 'json'
    }).done(function (json) {
        swal("Especialidade(s) adicionada(s) com sucesso!", "Click no botão abaixo!", "success");
        tableEspecialidades.ajax.reload();
        table.ajax.reload();

        //Limpar os campos do formulário
        limparCamposEspecialidade();
    });
});


//Evento de remover o telefone
$(document).on('click', '#deleteEspecialidade', function () {

    var idEspecialidade = tableEspecialidades.row($(this).parents('tr').index()).data().id;

    //Setando o o json para envio
    var dados = {
        'idEspecialidade' : idEspecialidade
    };

    // Requisição Ajax
    jQuery.ajax({
        type: 'POST',
        url: "/serbinario/especialista/destroyEspecialidade",
        data: dados,
        datatype: 'json'
    }).done(function (retorno) {
        swal("Especialidade removido com sucesso!", "Click no botão abaixo!", "success");
        tableEspecialidades.ajax.reload();
        table.ajax.reload();
    });
});

//Limpar os campos do formulário
function limparCamposEspecialidade()
{
    tipoOperacoes("");
    $('#especialidade optgroup').remove();
}



