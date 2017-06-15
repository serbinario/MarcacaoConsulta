{{--{{dd($dados)}}--}}
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
            text-align: center;
        }

        .rodape{
            position: absolute;
            bottom:0;
            width: 100%;
            height: 90px;
            margin-top: 70px;

        }


        table{
            width: 100%;
            top: 210px;
        }

        span, p {
            font-size: 13px;
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
        <center><img src="{{asset('/img/logo_igarassu.png')}}" style="width: 230px; height: 85px"></center>
    </div>
</center>

<p>
    <span style="font-size: 17"><b>Título:</b> Lista de pacientes</span> <br />
    <b>Especialista:</b> @if(isset($pacientes[0]->especialista)) {{$pacientes[0]->especialista}}@endif -
    <b>Especialidade:</b> @if(isset($pacientes[0]->especialidade)) {{$pacientes[0]->especialidade}}@endif <br />
    <b>Horário:</b> @if(isset($pacientes[0]->horario)) {{$pacientes[0]->horario}}@endif -
    <b>Local:</b> @if(isset($pacientes[0]->localidade)) {{$pacientes[0]->localidade}}@endif
</p>

<table class="center" border="1">
    <thead>
    <tr>
        <th>Paciente</th>
        <th>Nº SUS</th>
        <th>Atendido</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($pacientes as $paciente)
        <tr>
            <td>{{ $paciente->nome }}</td>
            <td>{{ $paciente->numero_sus }}</td>
            <td>{{ $paciente->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<center>
    <div class="rodape">
        <center>
            <img src="{{asset('/img/logo_igarassu.png')}}" style="width: 230px; height: 85px">
        </center>
    </div>
</center>
</body>
</html>
