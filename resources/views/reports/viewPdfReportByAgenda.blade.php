{{--{{dd($dados)}}--}}
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>

    </title>
    <style type="text/css">
        .centro{
            text-align: center;
        }

        #logo_rodape{
            margin-top: 200px;
        }

        #nomeEspecialista{
            margin-left: 128px;
        }

        table{
            width: 80%;
            position: absolute;
            top: 210px;
            left: 135px;
        }
    </style>
</head>
<body>
    <h1 class="centro logo">
        <img src="{{ asset('/img/logo_igarassu.png') }}">
    </h1>

    <p id="nomeEspecialista">Especialista: </p>

    <table class="center" border="1">
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Nº SUS</th>
                <th>Horário do Agendamento</th>
                <th>Especialidade</th>
                <th>Localidade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pacientes as $paciente)
                <tr>
                    <th>{{ $paciente->nomePaciente }}</th>
                    <th>{{ $paciente->numero_sus }}</th>
                    <th>{{ $paciente->hora }}</th>
                    <th>{{ $paciente->especialidade }}</th>
                    <th>{{ $paciente->localidade }}</th>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h1 id="logo_rodape" class="centro logo">
        <img src="{{ asset('/img/logo_igarassu.png') }}">
    </h1>
</body>
</html>
