<?php
// leitura das datas automaticamente
$dia = date('d');
$mes = date('m');
$ano = date('Y');
$semana = date('w');
//$cidade = "Digite aqui sua cidade";

// configuração mes

switch ($mes){

    case 1: $mes = "Janeiro"; break;
    case 2: $mes = "Fevereiro"; break;
    case 3: $mes = "Março"; break;
    case 4: $mes = "Abril"; break;
    case 5: $mes = "Maio"; break;
    case 6: $mes = "Junho"; break;
    case 7: $mes = "Julho"; break;
    case 8: $mes = "Agosto"; break;
    case 9: $mes = "Setembro"; break;
    case 10: $mes = "Outubro"; break;
    case 11: $mes = "Novembro"; break;
    case 12: $mes = "Dezembro"; break;

}


// configuração semana

switch ($semana) {

    case 0: $semana = "Domingo"; break;
    case 1: $semana = "Segunda Feira"; break;
    case 2: $semana = "Terça Feira"; break;
    case 3: $semana = "Quarta Feira"; break;
    case 4: $semana = "Quinta Feira"; break;
    case 5: $semana = "Sexta Feira"; break;
    case 6: $semana = "Sábado"; break;

}
//Agora basta imprimir na tela...
//echo ("$cidade, $semana, $dia de $mes de $ano");
?>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title></title>
    <style type="text/css" class="init">

        body {
            font-family: arial;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        table , tr , td {
            font-size: small;
        }
    </style>
    <link href="" rel="stylesheet" media="screen">
</head>

<table style="border: none;" id="topo" class="topo"  width="100%">
    <tr style="border: none">
        <td style="border: none; font-size: medium"><center>
                {{--@if(isset($crud['img']))
                    <img src="{{asset('/uploads/fotos/'.$crud['img'])}}" alt="Foto"  height="100" width="150">
                @endif--}}
            </center></td>
        <td style="border: none; font-size: medium">
            <center><h4>ALPHA EDUCAÇÃO E TREINAMENTOS</h4></center>
        </td>
        <td style="border: none; font-size: medium">
            <center>
                <span>CONTRATO</span>
            </center>
        </td>
    </tr>
</table>
<center><span>O DE PRESTAÇÕES DE SERVIÇOS EDUCACIONAIS</span></center>
<center><span>Pós-Graduação “Lato Sensu”</span></center>
<center><span>Pelo presente instrumento particular de <u>CONTRATO DE PRESTAÇÃO DE SERVIÇOS EDUCACIONAIS</u>
        com a <b>ALPHA EDUCAÇÃO E TREINAMENTOS</b>. Inscrita no CNPJ de nº 22.945385/0001-00, doravante denominado CONTRATADA,
        e do outro lado, o abaixo qualificado, doravante denominado de CONTRATANTE,
    </span></center><br />

<table width="100%">
    <tr>
        <td style="width: 20px"><b>Aluno</b></td>
        <td>{!! isset($aluno['nome']) ? $aluno['nome'] : "" !!}</td>
    </tr>
</table>
<br />

<span><b>Filiação: </b></span><span>{!! isset($aluno['nome_pai']) ? $aluno['nome_pai'] : "" !!} </span>e<span> {!! isset($aluno['nome_mae']) ? $aluno['nome_mae'] : "" !!}</span><br />
<span><b>Nacionalidade: </b></span><span>{!! isset($aluno['nacionalidade']) ? $aluno['nacionalidade'] : "" !!} </span><span><b>Naturalidade: </b></span><span>{!! isset($aluno['naturalidade']) ? $aluno['naturalidade'] : "" !!} </span><span><b>Estado Civil: </b></span><span>{!! isset($aluno['estadoCivil']['nome']) ? $aluno['estadoCivil']['nome'] : "" !!} </span><br />
<span><b>dentidade RG nº: </b></span><span>{!! isset($aluno['identidade']) ? $aluno['identidade'] : "" !!} </span><span><b>Org. Expedidor: </b></span><span>{!! isset($aluno['orgao_rg']) ? $aluno['orgao_rg'] : "" !!} </span><span><b>UF: </b></span><span>{!! isset($aluno['estado']['nome']) ? $aluno['estado']['nome'] : "" !!} </span><span><b>CPF nº: </b></span><span>{!! isset($aluno['cpf']) ? $aluno['cpf'] : "" !!} </span><br />
<?php
if(isset($aluno['data_nasciemento'])) {
    $date = explode('T', $aluno['data_nasciemento']);
    $data = \DateTime::createFromFormat('Y-m-d', $date[0]);
    $dataFromat = $data->format('d/m/Y');
} else {
    $dataFromat = "";
}
?>
<span><b>Data de nascimento: </b></span><span>{{$dataFromat}} </span><span><b>Sexo: </b></span><span>{!! isset($aluno['sexo']['nome']) ? $aluno['sexo']['nome'] : "" !!} </span><span><b>Residência: </b></span><span>{!! isset($aluno['endereco']['logradouro']) ? $aluno['endereco']['logradouro'] : "" !!} </span><br />
<span><b>Bairro: </b></span><span>{!! isset($aluno['endereco']['bairro']['nome']) ? $aluno['endereco']['bairro']['nome'] : "" !!} </span><span><b>Cidade: </b></span><span>{!! isset($aluno['endereco']['bairro']['cidade']['nome']) ? $aluno['endereco']['bairro']['cidade']['nome'] : "" !!} </span><span><b>CEP: </b></span><span>{!! isset($aluno['endereco']['cep']) ? $aluno['endereco']['cep'] : "" !!} </span><br />
<span><b>Telefones: {!! isset($aluno['telefone_fixo']) ? $aluno['telefone_fixo'] : "" !!} </b></span><span></span><br />
<span><b>Profissão: </b>{!! isset($aluno['profissao']['nome']) ? $aluno['profissao']['nome'] : "" !!} </span><br /><br />

<span>DOS FUNDAMENTOS LEGAIS</span><br />
<center><span><b>CLAUSULA I</b></span></center><br />
<ul>
    <li>1. O presente contrato é celebrado à vista do que dispõem: inciso IV do art. 1º, inciso II do art. 5º, inciso IV do art. 173</li>
    <li>2. Os artigos 81,82, 1.025, 1.079, 1.080 e 1.092 do Código Civil Brasileiro</li>
    <li>3. As Leis nº 8.069/90, 8.078/90, 8.880/94 e 9.069/95</li>
    <li>4. A Medida Provisória nº 1.477-43, de 03 de dezembro de 1997, com a aplicação dos critérios nela constantes, do conhecimento prévio do CONTRATANTE</li>
    <li>5. A certificação do contratante será dada pela Faculdade PARCEIRA DA ALPHA de acordo com contrato entre ambos.</li>
</ul><br />
<span>DO BENEFICIÁRIO</span><br /><br />

<h4>CLAUSULA II</h4>
<span>O beneficiário do presente Contrato será:</span><br />
<span><b>Nome: </b></span><span>{!! isset($aluno['nome']) ? $aluno['nome'] : "" !!} </span><span><b>Curso: </b></span><span> </span><br />
<span><b>Dia: </b></span><span></span><span><b>Polo: </b></span><span> </span><br /><br />
<span>DO OBJETO</span><br /><br />

<h4>CLAUSULA III</h4>
<span>
    Constitui objeto do presente Contrato, a prestação de Serviços Educacionais para o <b>Curso Pós Graduação “Lato Senso”</b>
    em ___________________________________________________________, ofertado pela ALPHA EDUCAÇÃO E
    TREINAMENTOS, de acordo com o prescrito na legislação acima citada, Estatuto e no Regimento Interno da ALPHA, as quais se
    obrigam a prestá-los ao beneficiário indicado neste Contrato, garantindo os padrões de qualidade estabelecidos pelo Ministério
    da Educação e a regularidade da oferta de ensino superior de qualidade
</span><br /><br />
<span>DO PRAZO DE DURAÇÃO</span><br /><br />

<h4>CLAUSULA IV</h4>
<span>
    O presente Contrato terá a duração de 15 meses, com início em _______de ____________ de ______ e termino em
    _______ de ____________ de ________
</span><br /><br />
<span>DA MATRÍCULA</span><br /><br />

<h4>CLAUSULA V</h4>
<span>
    A configuração formal do ato de matrícula se procede pelo preenchimento e assinatura do formulário próprio, fornecido
    pela CONTRATADA, denominado Requerimento de Matricula que desde já, fica fazendo parte integrante deste Contrato
</span><br /><br />
<span>DO REGIMENTO ESCOLAR</span><br /><br />

<h4>CLAUSULA VI</h4>
<span>
    O beneficiário estará sujeito às normas do Regimento interno da ALPHA, cujo teor está à disposição do
    CONTRATANTE, considerando-se o aludido Regimento como parte integrante deste Contrato
</span><br /><br />
<span>DO INVESTIMENTO E FORMA DE PAGAMENTO</span><br /><br />

<h4>CLAUSULA VII</h4>
<span>
    Como contraprestação dos serviços educacionais, acima referidos, será cobrado do CONTRATANTE <br>um investimento de
    R$ 2.400,00 (dois mil e quatrocentos reais), dividido em 1+ 15 (quinze) parcelas iguais mensais de R$ 150,00</b>, com vencimento no
    dia do módulo presencial. As parcelas podem variar de acordo com cada curso. A matricula só será devolvida caso não forme turma.
    § 1° O aluno que efetivar as mensalidades até o dia da aula terá um desconto de acordo com a promoção estipulada pela ALPHA
    sobre o valor da parcela, caso contrário o valor será integral. A Alpha tem um prazo de 4 meses para fechamento de turmas. O aluno
    será informado caso não feche turma. O aluno caso desista do curso deverá preencher o requerimento de solicitação e está com as
    parcelas em dias para realizar o trancamento.
</span><br /><br />
<span>DOS SERVIÇOS NÃO INCLUSOS NO PREÇO DO INVESTIMENTO</span><br /><br />

<h4>CLAUSULA VIII</h4>
<span>
    Não estão incluídos neste Contrato os serviços especiais e as taxas escolares, assim como: 2º chamada de provas,
    requerimentos, segunda via de declarações, certificado e outros serviços
</span><br /><br />
<span>DA INADIPLENCIA <b>CLAUSULA IX</b></span><br />
<span>
    Em caso de falta de pagamento no vencimento, ao valor da parcela em atraso, será acrescida multa e juros de mora, dentro
    dos limites da legislação em vigor.<br />
    § 1º No caso de inadimplência, a CONTRATADA poderá emitir letra de cambio, ou título de crédito legal, acrescido dos juros e da
    multa estabelecida no “caput” desta clausula e levar a protesto sem oposição do CONTRATANTE, ficando a critério da
    CONTRATADA promover a cobrança extrajudicial ou judicialmente.
    § 2º Só poderá receber o Certificado de Conclusão do Curso o beneficiário de cujo CONTRATANTE estiver quitado com a
    tesouraria da ALPHA.
</span><br /><br />
<span>DA RECISÃO</span><br /><br />

<h4>CLAUSULA X</h4>
<span>
    Este contrato poderá ser rescindido pelo CONTRATANTE, através de desistência formal, isto é, por pedido de
    cancelamento de matrícula e ainda pela CONTRATADA, quando o CONTRATANTE ou beneficiário do mesmo infringir o
    Regimento Interno do Estabelecimento de Ensino.
</span><br /><br />
<span>DA DISCUÇÃO JUDICIAL</span><br /><br />

<h4>CLAUSULA XI</h4>
<span>
    Na hipótese de discussão judicial sobre o presente Contrato, o CONTRATANTE continuará pagando o valor acordado
    neste contrato até a decisão final.<br />
    § Único: Em caso de interpretação divergente sobre dispositivo legal, entre a CONTRATADA e os órgãos de Defesa de
    Consumidor, querendo a CONTRATADA recorrerá ao Poder Judiciário, prevalecendo a interpretação da instituição, até decisão
    judicial transitada em julgado.
</span><br /><br />
<span>DA PLENA EFICÁCIA</span><br /><br />

<h4>CLAUSULA XII</h4>
<span>
    As partes atribuem ao presente Contrato plena eficácia e força Executiva Extrajudicial.
</span><br /><br />
<span>DO FORO</span><br /><br />

<h4>CLAUSULA XIII</h4>
<span>
    As partes elegem o foro da cidade de Recife, Estado de Pernambuco, para ajuizamento de qualquer demanda decorrente
    do presente Contrato, por mais privilegiado que outro tenha ou venha ter, como autora ou ré.<br />
    E por declararem as partes contratantes que conhecem todas as clausulas do presente contrato, sabendo que estão todos de
    acordo com a legislação vigente, nesta data, tornando-se as mesmas irretratáveis e irrevogáveis até o termo final deste Contrato,
    assinam o presente instrumento em 02 (duas) vias de igual teor e forma na presença de 02 (duas) testemunhas abaixo assinadas, para
    que se produzam todos os efeitos legais.
</span><br /><br />

<center><span>Recife, <?php echo ("$semana, $dia de $mes de $ano"); ?></span></center><br /><br />
<center><span>____________________________________<br />
                            CONTRATANTE
    </span></center><br /><br />
<center><span>____________________________________<br />
                            CONTRATADO
    </span></center><br /><br />
<table width="100%">
    <tr>
        <td><center>____________________________________<br />
                TESTEMUNHA</center>
        </td>
        <td>
            <center>____________________________________<br />
                TESTEMUNHA</center>
        </td>
    </tr>
</table>
</body>
</html>