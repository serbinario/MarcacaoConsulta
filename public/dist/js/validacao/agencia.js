// Regras de validação
$(document).ready(function () {

    $("#formAgencia").validate({
        rules: {
            numero_agencia: {
                required: true,
                bankBr: true,
                minlength: 4,
                maxlength: 15
            },
            nome_agencia: {
                required: true,
                alphaSpace: true
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