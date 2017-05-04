// Gereciamento de telefones para clientes encontrados no filtro de cpf

// Referencia global a table de telefones
var objTablePhone;

// Função construtora da table de telefones para editar
function TablePhonesEdit(_idClient) {
    // Atributo que armazenará o id do cliente
    this.idClient = _idClient;

    // Atributo que armazenará a table
    var table = $('#telefones-grid').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        ajax: '/contrato/telefone/grid/' + this.idClient,
        columns: [
            {data: 'telefone', name: 'telefones.telefone'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // Recupera a table carregada
    this.getTable = function () {
        return table;
    }

    // Eliminando a table
    this.tableDestroy = function () {
        this.getTable().destroy();
    }

    // Método que persisti o telefone no banco
    this.newFone = function () {
        // Recuperando o telefone
        var telefone = $('#addPhoneText').val();

        // Verificando se foi passado valor válido
        if (!telefone) {
            swal('Você deve informar um telefone!', "Click no botão abaixo!", 'error');
            return false;
        }

        // Requisição ajax
        jQuery.ajax({
            type: 'POST',
            url: '/contrato/telefone/store/' + this.idClient,
            data: {'telefone' : telefone},
            datatype: 'json',
            beforeSend: function () {
                $body = $('body');
                $body.addClass("loading");
            },
            complete: function () {
                $body.removeClass("loading");
            }
        }).done(function (json)  {
            // Limpando o campo
            $('#addPhoneText').val('');

            // Recarregando a grid
            table.ajax.reload();
        });
    };
}

// Função construtora da table de telefones para criar
function TablePhonesCreate() {
    // Atributo que armazenará a table
    var table = $('#telefones-grid').DataTable({
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false
    });

    // Recupera a table carregada
    this.getTable = function () {
        return table;
    }

    // Eliminando a table
    this.tableDestroy = function () {
        this.getTable().destroy();
    }

    // Método que persisti o telefone no banco
    this.newFone = function (_objDom) {
        // Recuperando o telefone
        var telefone = $('#addPhoneText').val();

        // Verificando se foi passado valor válido
        if (!telefone) {
            swal('Você deve informar um telefone!', "Click no botão abaixo!", 'error');
            return false;
        }

        // Limpando o campo de telefone
        $("#addPhoneText").val("");

        // Adicionando a linha na tabela
        table.row.add(
            [
                telefone,
                '<a class="btn-floating" onclick="objTablePhone.destroyPhone(this)" title="Contrato">Remover</a>'
            ]
        ).draw( false );
    };

    // Método para remover a linha da grid
    this.destroyPhone = function (_objDom) {
        // Removendo a linha da grid
        table.row( $(_objDom).parents('tr') )
            .remove()
            .draw();
    }
}