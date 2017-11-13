// Javascript para calend�rio

// Vari�veis globais
var table, idsPacientes, especialidadeId;
var totalVagas, vagasRestantes, idsPacientesFila;

$(document).ready(function () {

    var date = new Date();
    var m = date.getMonth();
    var y = date.getFullYear();
    var target = $('#calendar');

    // Campos da pesquisa zerados para carregamento inicial do calend�riowq
    var dados = {
        'idLocalidade': "",
        'idEspecialista': ""
    };

    // Submete a pesquisa para carregamento do calend�rio por especialista e localidade
    $('#btnConsultar').click(function () {
        var localidade = $('#localidade').val();
        var especialista = $('#especialista').val();
        var especialidade = $('#grupo_operacao').val();

        if (!localidade || !especialista || !especialidade) {
            swal("Por favor, preencha todos os campos para consultar!");
        }

        if (localidade && especialista) {

            // Dados necess�rio para carregar o calend�rio
            dados = {
                'idLocalidade': localidade,
                'idEspecialista': especialista
            };

            // Recarrega o calend�rio
            $('#calendar').fullCalendar('refetchEvents');
        }
    });

    target.fullCalendar({
        header: {
            right: '',
            center: '',
            left: ''
        },
        theme: false,
        selectable: true,
        selectHelper: true,
        editable: true,
        events: function (start, end, timezone, callback) {

            // Adicionando o loading da requisi��o
            $('body').addClass("loading");

            jQuery.ajax({
                url: "/serbinario/agendados/loadCalendarParaConsulta",
                type: 'POST',
                dataType: 'json',
                data: {
                    start: start.format(),
                    end: end.format(),
                    data: dados
                },
                success: function (doc) {

                    // Removendo o loading da requisi��o
                    $('body').removeClass("loading");

                    var events = [];
                    if (!!doc) {
                        $.map(doc, function (r) {
                            events.push({
                                //title: r.title,
                                start: r.date_start,
                                overlap: r.overlap,
                                rendering: r.rendering,
                                color: r.color,
                                id: r.color,
                            });
                        });
                    }
                    callback(events);
                }
            });


        },
        dayClick: function (date, allDay, jsEvent, view, resourceObj) {

            // Pega a data q foi clicada no calend�rio
            var data = date.format();
            $("#data").val(date.format());

            //Fun��o do submit do search da grid principal
            table.draw();

        },
        viewRender: function (view) {
            var calendarDate = $("#calendar").fullCalendar('getDate');
            var calendarMonth = calendarDate.month();
            //Set data attribute for header. This is used to switch header images using css
            //$('#calendar . fc-toolbar').attr('data-calendar-month', calendarMonth);
            //Set title in page header
            $('.block-header-calendar > h2 > span').html(view.title);
        }
    });
//Calendar views switch
    $('body').on('click', '[data-calendar-view]', function (e) {
        e.preventDefault();
        $('[data-calendar-view]').removeClass('active');
        $(this).addClass('active');
        var calendarView = $(this).attr('data-calendar-view');
        target.fullCalendar('changeView', calendarView);
    });
//Calendar Next
    $('body').on('click', '.calendar-next', function (e) {
        e.preventDefault();
        target.fullCalendar('prev');
    });
//Calendar Prev
    $('body').on('click', '.calendar-prev', function (e) {
        e.preventDefault();
        target.fullCalendar('next');
    });
});