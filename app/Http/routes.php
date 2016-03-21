<?php

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::get('login', 'Auth\AuthController@getLogin');
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
        });

        Route::group(['prefix' => 'ps', 'as' => 'ps.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'PostoSaudeController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'PostoSaudeController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'PostoSaudeController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'PostoSaudeController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'PostoSaudeController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'PostoSaudeController@update']);
        });

        Route::group(['prefix' => 'especialidade', 'as' => 'especialidade.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'EspecialidadeController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'EspecialidadeController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'EspecialidadeController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'EspecialidadeController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'EspecialidadeController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'EspecialidadeController@update']);
        });

        Route::group(['prefix' => 'especialista', 'as' => 'especialista.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'EspecialistaController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'EspecialistaController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'EspecialistaController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'EspecialistaController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'EspecialistaController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'EspecialistaController@update']);
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
            Route::post('select2', ['as' => 'select2', 'uses' => 'UtilController@queryByselect2']);
        });


//    Route::get('report/contratoAluno/{id}', ['as' => 'report.contratoAluno', 'uses' => 'ReportController@contratoAluno']);
//    Route::get('user/save/', ['as' => 'user.save', 'uses' => 'UserController@save']);
//    Route::Post('user/store/', ['as' => 'user.store', 'uses' => 'UserController@store']);
//    Route::Post('user/update/', ['as' => 'user.update', 'uses' => 'UserController@update']);
//    Route::get('user/edit/{id}', ['as' => 'user.edit', 'uses' => 'UserController@edit']);
//    Route::get('user/grid', ['as' => 'user.grid', 'uses' => 'UserController@grid']);
    });
});