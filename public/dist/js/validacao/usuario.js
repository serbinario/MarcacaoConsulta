// Regras de validação
$(document).ready(function () {

    $("#formUsuario").validate({
        rules: {
            email: {
                email: true
            },

            'userHole[opcaoOperador]': {
                integer: true,
                // required: true
            },

            'userHole[opcaoAdmin]': {
                integer: true,
                // required: true
            },

            'userHole[opcaoGerente]': {
                integer: true,
                // required: true
            },

            id_operadores: {
                integer: true,
                required: true
            }
        },
        //For custom messages
        /*messages: {
         nome_operadores:{
         required: "Enter a username",
         minlength: "Enter at least 5 characters"
         }
         },*/
        //Define qual elemento será adicionado
        errorElement : 'small',
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent());
        },

        highlight: function(element, errorClass) {
            //console.log("Error");
            $(element).parent().parent().addClass("has-error");
        },
        unhighlight: function(element, errorClass, validClass) {
            //console.log("Sucess");
            $(element).parent().parent().removeClass("has-error");

        }
    });
});