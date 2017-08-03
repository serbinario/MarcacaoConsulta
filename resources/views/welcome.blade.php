<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>
            </div>
        </div>
    </body>
</html>
{{--<script type="text/javascript">--}}

     {{--$(document).ready(function () { --}}

    {{--var idEstado = "";--}}
    {{--<?php if(isset($cliente['enderecosEnderecos']['bairrosBairros']['id'])){ ?>--}}
    {{--var idEstado = "<?php echo $cliente['enderecosEnderecos']['bairrosBairros']['cidadesCidades']['estadosEstados']['id']; ?>"--}}
    {{--var idCidade = "<?php echo $cliente['enderecosEnderecos']['bairrosBairros']['cidadesCidades']['id']; ?>"--}}
    {{--var idBairro = "<?php echo $cliente['enderecosEnderecos']['bairrosBairros']['id']; ?>"--}}
    {{--<?php } ?>--}}
    {{--//console.log(idEstado);--}}
    {{--//Carregando os estados--}}
    {{--jQuery.ajax({--}}
    {{--type: 'GET',--}}
    {{--url: '{{ Session::get('url_global') }}/estados/all',--}}
    {{--headers: {--}}
    {{--'Authorization': 'Bearer {{ Session::get("access_token") }}',--}}
    {{--//'X-CSRF-TOKEN' : '{{  csrf_token() }}'--}}
    {{--},--}}
    {{--datatype: 'json'--}}
    {{--}).done(function (json) {--}}
    {{--var option = "";--}}

    {{--option += '<option value="">Selecione um estado</option>';--}}
    {{--for (var i = 0; i < json.length; i++) {--}}
    {{--if (idEstado != null) {--}}
    {{--if (idEstado == json[i]['id']) {--}}
    {{--option += '<option selected value="' + json[i]['id'] + '">' + json[i]['prefixo'] + '</option>';--}}
    {{--} else {--}}
    {{--option += '<option value="' + json[i]['id'] + '">' + json[i]['prefixo'] + '</option>';--}}
    {{--}--}}
    {{--} else {--}}
    {{--option += '<option selected value="' + json[i]['id'] + '">' + json[i]['prefixo'] + '</option>';--}}
    {{--}--}}

    {{--}--}}

    {{--$('#estado option').remove();--}}
    {{--$('#estado').append(option);--}}
    {{--});--}}

    {{--<?php if(isset($cliente['enderecosEnderecos']['bairrosBairros']['id'])){ ?>--}}
    {{--//Carregando os cidades--}}
    {{--jQuery.ajax({--}}
    {{--type: 'POST',--}}
    {{--url: '{{ Session::get('url_global') }}/gen_cidades/byestado',--}}
    {{--headers: {--}}
    {{--'Authorization': 'Bearer {{ Session::get("access_token") }}',--}}
    {{--//'X-CSRF-TOKEN' : '{{  csrf_token() }}'--}}
    {{--},--}}
    {{--data: {estado : idEstado},--}}
    {{--datatype: 'json'--}}
    {{--}).done(function (json) {--}}
    {{--var option = "";--}}

    {{--option += '<option value="">Selecione uma cidade</option>';--}}
    {{--for (var i = 0; i < json.length; i++) {--}}
    {{--if (idCidade != null) {--}}
    {{--if (idCidade == json[i]['id']) {--}}
    {{--option += '<option selected value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';--}}
    {{--} else {--}}
    {{--option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';--}}
    {{--}--}}
    {{--} else {--}}
    {{--option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';--}}
    {{--}--}}

    {{--}--}}

    {{--$('#cidade option').remove();--}}
    {{--$('#cidade').append(option);--}}
    {{--});--}}

    {{--//Carregando os bairros--}}
    {{--jQuery.ajax({--}}
    {{--type: 'POST',--}}
    {{--url: '{{ Session::get('url_global') }}/bairros/bycidade',--}}
    {{--headers: {--}}
    {{--'Authorization': 'Bearer {{ Session::get("access_token") }}',--}}
    {{--//'X-CSRF-TOKEN' : '{{  csrf_token() }}'--}}
    {{--},--}}
    {{--data: {cidade : idCidade},--}}
    {{--datatype: 'json'--}}
    {{--}).done(function (json) {--}}
    {{--var option = "";--}}

    {{--option += '<option value="">Selecione uma cidade</option>';--}}
    {{--for (var i = 0; i < json.length; i++) {--}}
    {{--if (idBairro != null) {--}}
    {{--if (idBairro == json[i]['id']) {--}}
    {{--option += '<option selected value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';--}}
    {{--} else {--}}
    {{--option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';--}}
    {{--}--}}
    {{--} else {--}}
    {{--option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';--}}
    {{--}--}}

    {{--}--}}

    {{--$('#bairro option').remove();--}}
    {{--$('#bairro').append(option);--}}
    {{--});--}}

    {{--<?php } ?>--}}
    {{--//Carregando as gen_cidades--}}
    {{--$(document).on('change', "#estado", function () {--}}
    {{--var estado = $(this).val();--}}

    {{--if (estado !== "") {--}}
    {{--var dados = {--}}
    {{--estado: estado--}}
    {{--}--}}

    {{--jQuery.ajax({--}}
    {{--type: 'POST',--}}
    {{--url: '{{ Session::get('url_global') }}/gen_cidades/byestado',--}}
    {{--headers: {--}}
    {{--'Authorization': 'Bearer {{ Session::get("access_token") }}',--}}
    {{--//'X-CSRF-TOKEN': '{{  csrf_token() }}'--}}
    {{--},--}}
    {{--data: dados,--}}
    {{--datatype: 'json'--}}
    {{--}).done(function (json) {--}}
    {{--var option = "";--}}

    {{--option += '<option value="">Selecione uma cidade</option>';--}}
    {{--for (var i = 0; i < json.length; i++) {--}}
    {{--option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';--}}
    {{--}--}}

    {{--$('#cidade option').remove();--}}
    {{--$('#cidade').append(option);--}}
    {{--});--}}
    {{--}--}}
    {{--});--}}

    {{--//Carregando os bairros--}}
    {{--$(document).on('change', "#cidade", function () {--}}
    {{--var cidade = $(this).val();--}}

    {{--if (cidade !== "") {--}}
    {{--var dados = {--}}
    {{--cidade: cidade--}}
    {{--}--}}

    {{--jQuery.ajax({--}}
    {{--type: 'POST',--}}
    {{--url: '{{ Session::get('url_global') }}/bairros/bycidade',--}}
    {{--headers: {--}}
    {{--'Authorization': 'Bearer {{ Session::get("access_token") }}',--}}
    {{--//'X-CSRF-TOKEN': '{{  csrf_token() }}'--}}
    {{--},--}}
    {{--data: dados,--}}
    {{--datatype: 'json'--}}
    {{--}).done(function (json) {--}}
    {{--var option = "";--}}

    {{--option += '<option value="">Selecione um bairro</option>';--}}
    {{--for (var i = 0; i < json.length; i++) {--}}
    {{--option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';--}}
    {{--}--}}

    {{--$('#bairro option').remove();--}}
    {{--$('#bairro').append(option);--}}
    {{--});--}}
    {{--}--}}
    {{--});--}}

    {{--//verificando o cpf do aluno--}}
    {{--$(document).on("focusout", "#cpfAlunos", function () {--}}
    {{--//Recuperando o valor do campo--}}
    {{--var valueName  = $(this).val();--}}
    {{--var idAlunos   = $("#idAluno").val();--}}

    {{--//Preparando os parâmetros--}}
    {{--var parameters = {--}}
    {{--'valueName': valueName,--}}
    {{--'tableName': 'SerAcademicoBundle:Alunos',--}}
    {{--'fieldName': 'cpf',--}}
    {{--'id'       : idAlunos--}}
    {{--}--}}

    {{--//Executando a consulta--}}
    {{--validateUniqueField(parameters, "#cpfAlunos");--}}
    {{--});--}}

    {{--//verificando o email do aluno--}}
    {{--$(document).on("focusout", "#emailAlunos", function () {--}}
    {{--//Recuperando o valor do campo--}}
    {{--var valueName  = $(this).val();--}}
    {{--var idAlunos   = $("#idAluno").val();--}}

    {{--//Preparando os parâmetros--}}
    {{--var parameters = {--}}
    {{--'valueName': valueName,--}}
    {{--'tableName': 'SerAcademicoBundle:Alunos',--}}
    {{--'fieldName': 'email',--}}
    {{--'id'       : idAlunos--}}
    {{--}--}}

    {{--//Executando a consulta--}}
    {{--validateUniqueField(parameters, "#emailAlunos");--}}
    {{--});--}}

    {{--//Consulta da instituição de 2 grau--}}
    {{--$("#instituicao").select2({--}}
    {{--data: {"id": 1, "text": "text"},--}}
    {{--placeholder: 'Selecione uma instituição',--}}
    {{--minimumInputLength: 3,--}}
    {{--width: 850,--}}
    {{--ajax: {--}}
    {{--type: 'POST',--}}
    {{--url: "{{ Session::get('url_global') }}/util/search",--}}
    {{--dataType: 'json',--}}
    {{--delay: 250,--}}
    {{--crossDomain: true,--}}
    {{--data: function (params) {--}}
    {{--return {--}}
    {{--search:     params.term, // search term--}}
    {{--tableName:  'SerAcademicoBundle:Instituicao',--}}
    {{--fieldName:  'nome',--}}
    {{--page:       params.page--}}
    {{--};--}}
    {{--},--}}
    {{--headers: {--}}
    {{--//"Access-Control-Allow-Origin" : "http://ser.academicoc",--}}
    {{--'Authorization': 'Bearer {{ Session::get("access_token") }}',--}}
    {{--'X-CSRF-TOKEN' : '{{  csrf_token() }}'--}}
    {{--},--}}
    {{--processResults: function (data, params) {--}}

    {{--//Veja a documentação select2, o parametro pagination ele pagina ao rolar até o fim da select--}}
    {{--//porem tem que passar um parametro chamado total_cout--}}

    {{--// parse the results into the format expected by Select2--}}
    {{--// since we are using custom formatting functions we do not need to--}}
    {{--// alter the remote JSON data, except to indicate that infinite--}}
    {{--// scrolling can be used--}}
    {{--params.page = params.page || 1;--}}

    {{--return {--}}
    {{--results: data,--}}
    {{--//Aqui que faz a paginação porem tem que receber o parametro total_count--}}
    {{--pagination: {--}}
    {{--more: (params.page * 30) < data.total_count--}}
    {{--}--}}
    {{--};--}}
    {{--}--}}
    {{--}--}}
    {{--});--}}

    {{--});--}}

    {{--//envio da requisição para o servidor--}}
    {{--function validateUniqueField(parameters, idTag) {--}}
    {{--//Carregando os estados--}}
    {{--jQuery.ajax({--}}
    {{--type: 'POST',--}}
    {{--data: parameters,--}}
    {{--url: '{{ Session::get('url_global') }}/util/queryByField',--}}
    {{--headers: {--}}
    {{--//"Access-Control-Allow-Origin" : "http://ser.academicoc",--}}
    {{--'Authorization': 'Bearer {{ Session::get("access_token") }}',--}}
    {{--'X-CSRF-TOKEN' : '{{  csrf_token() }}'--}}
    {{--},--}}
    {{--datatype: 'json'--}}
    {{--}).done(function (retorno) {--}}
    {{--var msg = "";--}}

    {{--if(retorno) {--}}
    {{--$(idTag).parent().addClass("has-error");--}}
    {{--msg += "<span id='helpBlock2' style='font-size: 11px;' class='help-block'>O valor informado já existe</span>";--}}
    {{--$("#helpBlock2").remove();--}}
    {{--$(idTag).parent().append(msg);--}}
    {{--$(idTag).focus();--}}
    {{--} else {--}}
    {{--$("#helpBlock2").remove();--}}
    {{--$(this).parent().parent().removeClass("has-error");--}}
    {{--}--}}

    {{--});--}}
    {{--}--}}
{{--</script>--}}
