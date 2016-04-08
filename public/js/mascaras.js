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

    //Telefone
    $('.phone').mask('(00)00000.000');

    //Telefone
    $('.hora').mask('00:00');

    //##### Submeter formulário
    $('#formAluno').submit(function() {
        $('.cpf').unmask();
    });
     
    //######## Mascaras para formulário empreendedor ##########

     
     //Vaga disponível
     $('#serbinario_sad_bundle_sadbundle_vagasdisponiveis_qtdVagas').mask('0000000000000000000', {reverse: true});
});