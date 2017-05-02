$.validator.addMethod("unique",
    function(value, element, params) {
        //Variavel de uso
        $body = $('body');
        var isUnique = false;

        if(value == '') {
            return isUnique;
        }

        id_send= '';
        if(params[1] !='')
            id_send ='id='+params[1]+'&';

        $.ajax({
            url: params[0],
            type : 'POST',
            async: false,
            data: { idModel : params[1], value : value},
            dataType: 'json',
            cache: true,
            beforeSend: function () {
                $body.addClass("loading");
            },
            complete: function () {
                $body.removeClass("loading");
            },
            success: function(data){
            if (data.success == false) {
                isUnique = true;
            }
        }
        });

        return isUnique;

    },
    $.validator.format("Este número já se encontra cadastrado")
);