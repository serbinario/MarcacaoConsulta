<?php

Route::get('/', function () {
    return redirect()->route('auth.login');
});

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
        Route::post('login', 'Auth\AuthController@postLogin');
        Route::get('logout', 'Auth\AuthController@getLogout');
    });

    Route::group(['prefix' => 'serbinario', 'middleware' => 'auth', 'as' => 'serbinario.'], function () {
//    Route::get('login'  , ['as' => 'login', 'uses' => 'SecurityController@login']);
//    Route::get('logout'  , ['as' => 'logout', 'uses' => 'SecurityController@logout']);
//    Route::post('check'  , ['as' => 'check', 'uses' => 'SecurityController@check']);
//    Route::get('index'  , ['as' => 'index', 'middleware'=>'security:ROLE_ADMIN', 'uses' => 'DefaultController@index']);
//    Route::get('update2'  , ['as' => 'update2', 'middleware'=>'security:ROLE_ADMIN', 'uses' => 'DefaultController@update2']);

        Route::get('index'  , ['as' => 'index', 'uses' => 'DefaultController@index']);

        Route::group(['prefix' => 'cgm', 'as' => 'cgm.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'CGMController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'CGMController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'CGMController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'CGMController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'CGMController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'CGMController@update']);
        });

        Route::group(['prefix' => 'localidade', 'as' => 'localidade.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'LocalidadeController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'LocalidadeController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'LocalidadeController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'LocalidadeController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'LocalidadeController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'LocalidadeController@update']);
            Route::post('all', ['as' => 'all', 'uses' => 'LocalidadeController@all']);
            Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'LocalidadeController@destroy']);
        });

        Route::group(['prefix' => 'ps', 'as' => 'ps.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'PostoSaudeController@index']);
            Route::post('all', ['as' => 'all', 'uses' => 'PostoSaudeController@all']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'PostoSaudeController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'PostoSaudeController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'PostoSaudeController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'PostoSaudeController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'PostoSaudeController@update']);
            Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'PostoSaudeController@destroy']);
        });

        Route::group(['prefix' => 'especialidade', 'as' => 'especialidade.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'EspecialidadeController@index']);
            Route::post('all', ['as' => 'all', 'uses' => 'EspecialidadeController@all']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'EspecialidadeController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'EspecialidadeController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'EspecialidadeController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'EspecialidadeController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'EspecialidadeController@update']);
            Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'EspecialidadeController@destroy']);
        });

        Route::group(['prefix' => 'especialista', 'as' => 'especialista.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'EspecialistaController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'EspecialistaController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'EspecialistaController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'EspecialistaController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'EspecialistaController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'EspecialistaController@update']);
            Route::get('byespecialidade/{id}', ['as' => 'byespecialidade', 'uses' => 'EspecialistaController@getByEspacialidade']);
            Route::post('especialidades', ['as' => 'especialidades', 'uses' => 'EspecialistaController@getEspecialidades']);
            Route::post('especialidadesEspecificas', ['as' => 'especialidadesEspecificas', 'uses' => 'EspecialistaController@getEspecialidadesEspecificas']);
            Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'EspecialistaController@destroy']);
            Route::get('agenda/{id}', ['as' => 'agenda', 'uses' => 'CalendarioController@index']);

            // Adicionar especialidades
            Route::post('getTipoOperacao', ['as' => 'getTipoOperacao', 'uses' => 'EspecialistaController@getTipoOperacao']);
            Route::get('gridEspecialidades/{id}', ['as' => 'gridEspecialidades', 'uses' => 'EspecialistaController@gridEspecialidades']);
            Route::post('storeEspecialidade', ['as' => 'storeEspecialidade', 'uses' => 'EspecialistaController@storeEspecialidade']);
            Route::post('destroyEspecialidade', ['as' => 'destroyEspecialidade', 'uses' => 'EspecialistaController@destroyEspecialidade']);
        });

        Route::group(['prefix' => 'agenda', 'as' => 'agenda.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'EspecialistaController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'EspecialistaController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'EspecialistaController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'EspecialistaController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'EspecialistaController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'EspecialistaController@update']);
        });

        Route::group(['prefix' => 'calendario', 'as' => 'calendario.'], function () {
            Route::get('index/{id}', ['as' => 'index', 'uses' => 'CalendarioController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'CalendarioController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'CalendarioController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'CalendarioController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'CalendarioController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'CalendarioController@update']);
            Route::get('deletar/{id}', ['as' => 'deletar', 'uses' => 'CalendarioController@deletar']);
            Route::get('calendarios/{id}', ['as' => 'calendarios', 'uses' => 'CalendarioController@getCalendarioByMedico']);
            Route::post('calendariodata', ['as' => 'calendariodata', 'uses' => 'CalendarioController@findCalendarioData']);
            Route::post('calendariodatamedico', ['as' => 'calendariodatamedico', 'uses' => 'CalendarioController@findCalendarioDataMedico']);
            Route::post('calendarioEspecialista', ['as' => 'calendarioEspecialista', 'uses' => 'CalendarioController@getCalendarioEspecialista']);
            Route::post('getCalendario', ['as' => 'getCalendario', 'uses' => 'CalendarioController@getCalendario']);
            Route::post('getVagasByMapa', ['as' => 'getVagasByMapa', 'uses' => 'CalendarioController@getVagasByMapa']);
            Route::post('reagendamento', ['as' => 'reagendamento', 'uses' => 'CalendarioController@reagendamento']);
            Route::post('agendamento', ['as' => 'agendamento', 'uses' => 'CalendarioController@agendamento']);
            Route::POST('gridCalendario/{id}', ['as' => 'gridCalendario', 'uses' => 'CalendarioController@gridCalendario']);

            Route::get('fechar/{id}', ['as' => 'fechar', 'uses' => 'CalendarioController@fechar']);
            Route::post('bloquear', ['as' => 'bloquear', 'uses' => 'CalendarioController@bloquear']);

            // Pacientes e remarcações
            Route::get('gridPacientes/{id}', ['as' => 'gridPacientes', 'uses' => 'CalendarioController@gridPacientes']);
        });

        Route::group(['prefix' => 'agendamento', 'as' => 'agendamento.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'AgendamentoController@index']);
            Route::get('index/loc/{loc}/esp/{esp}', ['as' => 'index', 'uses' => 'AgendamentoController@index']);
            Route::post('calendarMedico', ['as' => 'calendar', 'uses' => 'AgendamentoController@calendarMedico']);
            Route::post('loadCalendar', ['as' => 'loadCalendar', 'uses' => 'AgendamentoController@loadCalendar']);
            Route::post('store', ['as' => 'store', 'uses' => 'AgendamentoController@store']);
            Route::post('edit/{id}', ['as' => 'edit', 'uses' => 'AgendamentoController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'AgendamentoController@update']);
            Route::post('delete/{id}', ['as' => 'delete', 'uses' => 'AgendamentoController@delete']);
            Route::post('getTipoOperacao', ['as' => 'getTipoOperacao', 'uses' => 'AgendamentoController@getTipoOperacao']);
            Route::post('getGrupoOperacao/{id}', ['as' => 'getGrupoOperacao', 'uses' => 'AgendamentoController@getGrupoOperacao']);
            Route::post('getPacientes', ['as' => 'getPacientes', 'uses' => 'AgendamentoController@getPacientes']);
        });

        Route::group(['prefix' => 'agendados', 'as' => 'agendados.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'AgendadosController@index']);
            Route::get('indexDois', ['as' => 'indexDois', 'uses' => 'AgendadosController@indexDois']);
            Route::post('grid', ['as' => 'grid', 'uses' => 'AgendadosController@grid']);
            Route::post('alterarSituacao', ['as' => 'alterarSituacao', 'uses' => 'AgendadosController@alterarSituacao']);
            Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'AgendadosController@delete']);

            // Rotas para o a consulta de pacientes agendados com o uso do calendário
            Route::get('indexDois', ['as' => 'indexDois', 'uses' => 'AgendadosController@indexDois']);
            Route::post('loadCalendarParaConsulta', ['as' => 'loadCalendarParaConsulta', 'uses' => 'AgendamentoController@loadCalendarParaConsulta']);
        });


        Route::group(['prefix' => 'fila', 'as' => 'fila.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'FilaController@index']);
            Route::post('all', ['as' => 'all', 'uses' => 'FilaController@all']);
            Route::post('grid', ['as' => 'grid', 'uses' => 'FilaController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'FilaController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'FilaController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'FilaController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'FilaController@update']);
            Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'FilaController@destroy']);

            Route::post('getDadosPaciente', ['as' => 'getDadosPaciente', 'uses' => 'FilaController@getDadosDoPaciente']);
        });

        Route::group(['prefix' => 'operacao', 'as' => 'operacao.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'OperacoeController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'OperacoeController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'OperacoeController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'OperacoeController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'OperacoeController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'OperacoeController@update']);
            Route::post('all', ['as' => 'all', 'uses' => 'OperacoeController@all']);
            Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'OperacoeController@destroy']);
        });

        Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'UserController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'UserController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'UserController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'UserController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'UserController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'UserController@update']);
        });

        Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'RoleController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'RoleController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'RoleController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'RoleController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'RoleController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'RoleController@update']);
        });

        Route::group(['prefix' => 'util', 'as' => 'util.'], function () {
            Route::post('search', ['as' => 'search', 'uses' => 'UtilController@search']);
            Route::post('searchOperacoes', ['as' => 'searchOperacoes', 'uses' => 'UtilController@searchOperacoes']);
            Route::post('select2', ['as' => 'select2', 'uses' => 'UtilController@queryByselect2']);
            Route::post('select2Agenda', ['as' => 'select2Agenda', 'uses' => 'UtilController@queryByselect2Agenda']);
            Route::post('select2FilaDeEspera', ['as' => 'select2FilaDeEspera', 'uses' => 'UtilController@queryByselect2FilaDeEspera']);
        });

        Route::group(['prefix' => 'relatorio', 'as' => 'relatorio.'], function () {
            Route::get('byAgenda', ['as' => 'byAgenda', 'uses' => 'RelatorioController@indexByAgenda']);
            Route::get('reportPdf', ['as' => 'reportPdf', 'uses' => 'RelatorioController@reportPdf']);
            Route::post('reportByAgenda', ['as' => 'reportByAgenda', 'uses' => 'RelatorioController@gridReportByAgenda']);
            Route::get('reportPdfByAgenda', ['as' => 'reportPdfByAgenda', 'uses' => 'RelatorioController@reportPdfByAgenda']);
        });

//    Route::get('report/contratoAluno/{id}', ['as' => 'report.contratoAluno', 'uses' => 'ReportController@contratoAluno']);
//    Route::get('user/save/', ['as' => 'user.save', 'uses' => 'UserController@save']);
//    Route::Post('user/store/', ['as' => 'user.store', 'uses' => 'UserController@store']);
//    Route::Post('user/update/', ['as' => 'user.update', 'uses' => 'UserController@update']);
//    Route::get('user/edit/{id}', ['as' => 'user.edit', 'uses' => 'UserController@edit']);
//    Route::get('user/grid', ['as' => 'user.grid', 'uses' => 'UserController@grid']);
    });
});