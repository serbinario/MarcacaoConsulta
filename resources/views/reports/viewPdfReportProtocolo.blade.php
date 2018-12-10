
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>

    </title>
    <style type="text/css">

        body {
            font-family: arial;
        }

        table,  th,  td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        td {
            text-align: left;
        }

        .rodape {
            position: absolute;
            bottom:0;
            width: 100%;
            height: 90px;
            margin-top: 70px;
        }

        table {
            width: 100%;
            top: 210px;
        }

        span, p {
            font-size: 16px;
        }

        table { page-break-inside:auto }
        tr { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }
    </style>
</head>
<body>
<center>
    <div>

    </div>
</center>

<h3 style="text-align: center">Secretaria Muncipal de Saúde</h3>
<h4 style="text-align: center">Solicitaçao de exames e consultas especializadas </h4>

<p>

</p>


<table style="width: 400px; text-align: left" align="center"  class="center" border="1">
    <thead>
    <tr>
        <th>Nome: {{ $pacientes->nome }}</th>
    </tr>
    <tr>
        <th>CPF: {{ $pacientes->cpf }}</th>
    </tr>
    <tr>
        <th>Data Nasc.: {{ $pacientes->data_nascimento }}</th>
    </tr>
    <tr>
        <th>SUS: {{ $pacientes->numero_sus }}</th>
    </tr>
    <tr>
        <th>UNI. Solicitante</th>
    </tr>
    <tr>
        <th>Proficional: </th>
    </tr>
    <tr>
        <th>Data Solic. {{ $pacientes->data }}</th>
    </tr>
    <tr>
        <th>Espicialidade: {{ $pacientes->operacao_nome }}</th>
    </tr>
    <tr>
        <th>Observaçao:</th>
    </tr>
    <tr>
        <th>{!! Form::textarea('null', $pacientes->observacao,
                            array('class' => 'form-control input-sm', 'rows' => '4','placeholder' => 'Adicione uma observação')) !!}</th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>



<center>
    <div class="rodape">
        <center>

        </center>
    </div>
</center>
</body>
</html>
