$(document).ready(function(){

    //######## Mascaras para formulário candidato ##########

    //Cpf
    $('.cpf').mask('000.000.000-00', {reverse: true});
    //RG
    $('.rg').mask('0.000.000', {reverse: true});
    //CEP
    $('.cep').mask('00000-000');
    //money
    $('.money').mask('000.000.000,00', {reverse: true});
    //CNPJ
    $('.cnpj').mask('00.000.000.0000-00');

    //Numeros
    $('.number').mask('#0' , {reverse: true});

    //Numeros
    $('.numberTwo').mask('00');

    //Numeros
    $('.numberThree').mask('000');

    //Numeros
    $('.numberFor').mask('0000');

    //Numeros
    $('.numberFive').mask('00000');

    //código
    $('.codigo').mask('###');

    //Data
    $('.date').mask('00/00/0000');

    // Data e Hora
    $('.datetime').mask('00/00/0000 00:00:00');

    $('.time').mask('00:00:00' , {reverse: true});

    $('.hora').mask('00:00:00' , {reverse: true});

    //##### Submeter formulário
    $('#formAluno').submit(function() {
        $('.cpf').unmask();
        $('.phone').unmask();
    });

    //##### Submeter formulário
    $('#formVestibulando').submit(function() {
        $('.cpf').unmask();
        $('.phone').unmask();
    });

    //######## Mascaras para formulário empreendedor ##########

    $(document).on('focus', ".telefone", function () {
        var maskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            options = {onKeyPress: function (val, e, field, options) {
                field.mask(maskBehavior.apply({}, arguments), options);
            }
            };
        $('.telefone').mask(maskBehavior, options);
    });
});