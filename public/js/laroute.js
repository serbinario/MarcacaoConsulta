(function () {

    var laroute = (function () {

        var routes = {

            absolute: false,
            rootUrl: 'http://localhost',
            routes : [{"host":null,"methods":["GET","HEAD"],"uri":"auth\/login","name":null,"action":"Seracademico\Http\Controllers\Auth\AuthController@getLogin"},{"host":null,"methods":["POST"],"uri":"auth\/login","name":null,"action":"Seracademico\Http\Controllers\Auth\AuthController@postLogin"},{"host":null,"methods":["GET","HEAD"],"uri":"auth\/logout","name":null,"action":"Seracademico\Http\Controllers\Auth\AuthController@getLogout"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/index","name":"serbinario.index","action":"Seracademico\Http\Controllers\DefaultController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/cgm\/index","name":"serbinario.cgm.index","action":"Seracademico\Http\Controllers\CGMController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/cgm\/grid","name":"serbinario.cgm.grid","action":"Seracademico\Http\Controllers\CGMController@grid"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/cgm\/create","name":"serbinario.cgm.create","action":"Seracademico\Http\Controllers\CGMController@create"},{"host":null,"methods":["POST"],"uri":"serbinario\/cgm\/store","name":"serbinario.cgm.store","action":"Seracademico\Http\Controllers\CGMController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/cgm\/edit\/{id}","name":"serbinario.cgm.edit","action":"Seracademico\Http\Controllers\CGMController@edit"},{"host":null,"methods":["POST"],"uri":"serbinario\/cgm\/update\/{id}","name":"serbinario.cgm.update","action":"Seracademico\Http\Controllers\CGMController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/localidade\/index","name":"serbinario.localidade.index","action":"Seracademico\Http\Controllers\LocalidadeController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/localidade\/grid","name":"serbinario.localidade.grid","action":"Seracademico\Http\Controllers\LocalidadeController@grid"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/localidade\/create","name":"serbinario.localidade.create","action":"Seracademico\Http\Controllers\LocalidadeController@create"},{"host":null,"methods":["POST"],"uri":"serbinario\/localidade\/store","name":"serbinario.localidade.store","action":"Seracademico\Http\Controllers\LocalidadeController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/localidade\/edit\/{id}","name":"serbinario.localidade.edit","action":"Seracademico\Http\Controllers\LocalidadeController@edit"},{"host":null,"methods":["POST"],"uri":"serbinario\/localidade\/update\/{id}","name":"serbinario.localidade.update","action":"Seracademico\Http\Controllers\LocalidadeController@update"},{"host":null,"methods":["POST"],"uri":"serbinario\/localidade\/all","name":"serbinario.localidade.all","action":"Seracademico\Http\Controllers\LocalidadeController@all"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/ps\/index","name":"serbinario.ps.index","action":"Seracademico\Http\Controllers\PostoSaudeController@index"},{"host":null,"methods":["POST"],"uri":"serbinario\/ps\/all","name":"serbinario.ps.all","action":"Seracademico\Http\Controllers\PostoSaudeController@all"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/ps\/grid","name":"serbinario.ps.grid","action":"Seracademico\Http\Controllers\PostoSaudeController@grid"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/ps\/create","name":"serbinario.ps.create","action":"Seracademico\Http\Controllers\PostoSaudeController@create"},{"host":null,"methods":["POST"],"uri":"serbinario\/ps\/store","name":"serbinario.ps.store","action":"Seracademico\Http\Controllers\PostoSaudeController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/ps\/edit\/{id}","name":"serbinario.ps.edit","action":"Seracademico\Http\Controllers\PostoSaudeController@edit"},{"host":null,"methods":["POST"],"uri":"serbinario\/ps\/update\/{id}","name":"serbinario.ps.update","action":"Seracademico\Http\Controllers\PostoSaudeController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/especialidade\/index","name":"serbinario.especialidade.index","action":"Seracademico\Http\Controllers\EspecialidadeController@index"},{"host":null,"methods":["POST"],"uri":"serbinario\/especialidade\/all","name":"serbinario.especialidade.all","action":"Seracademico\Http\Controllers\EspecialidadeController@all"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/especialidade\/grid","name":"serbinario.especialidade.grid","action":"Seracademico\Http\Controllers\EspecialidadeController@grid"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/especialidade\/create","name":"serbinario.especialidade.create","action":"Seracademico\Http\Controllers\EspecialidadeController@create"},{"host":null,"methods":["POST"],"uri":"serbinario\/especialidade\/store","name":"serbinario.especialidade.store","action":"Seracademico\Http\Controllers\EspecialidadeController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/especialidade\/edit\/{id}","name":"serbinario.especialidade.edit","action":"Seracademico\Http\Controllers\EspecialidadeController@edit"},{"host":null,"methods":["POST"],"uri":"serbinario\/especialidade\/update\/{id}","name":"serbinario.especialidade.update","action":"Seracademico\Http\Controllers\EspecialidadeController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/especialista\/index","name":"serbinario.especialista.index","action":"Seracademico\Http\Controllers\EspecialistaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/especialista\/grid","name":"serbinario.especialista.grid","action":"Seracademico\Http\Controllers\EspecialistaController@grid"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/especialista\/create","name":"serbinario.especialista.create","action":"Seracademico\Http\Controllers\EspecialistaController@create"},{"host":null,"methods":["POST"],"uri":"serbinario\/especialista\/store","name":"serbinario.especialista.store","action":"Seracademico\Http\Controllers\EspecialistaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/especialista\/edit\/{id}","name":"serbinario.especialista.edit","action":"Seracademico\Http\Controllers\EspecialistaController@edit"},{"host":null,"methods":["POST"],"uri":"serbinario\/especialista\/update\/{id}","name":"serbinario.especialista.update","action":"Seracademico\Http\Controllers\EspecialistaController@update"},{"host":null,"methods":["POST"],"uri":"serbinario\/especialista\/byespecialidade\/{id}","name":"serbinario.especialista.byespecialidade","action":"Seracademico\Http\Controllers\EspecialistaController@getByEspacialidade"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/especialista\/agenda\/{id}","name":"serbinario.especialista.agenda","action":"Seracademico\Http\Controllers\CalendarioController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/agenda\/index","name":"serbinario.agenda.index","action":"Seracademico\Http\Controllers\EspecialistaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/agenda\/grid","name":"serbinario.agenda.grid","action":"Seracademico\Http\Controllers\EspecialistaController@grid"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/agenda\/create","name":"serbinario.agenda.create","action":"Seracademico\Http\Controllers\EspecialistaController@create"},{"host":null,"methods":["POST"],"uri":"serbinario\/agenda\/store","name":"serbinario.agenda.store","action":"Seracademico\Http\Controllers\EspecialistaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/agenda\/edit\/{id}","name":"serbinario.agenda.edit","action":"Seracademico\Http\Controllers\EspecialistaController@edit"},{"host":null,"methods":["POST"],"uri":"serbinario\/agenda\/update\/{id}","name":"serbinario.agenda.update","action":"Seracademico\Http\Controllers\EspecialistaController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/calendario\/index\/{id}","name":"serbinario.calendario.index","action":"Seracademico\Http\Controllers\CalendarioController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/calendario\/grid","name":"serbinario.calendario.grid","action":"Seracademico\Http\Controllers\CalendarioController@grid"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/calendario\/create","name":"serbinario.calendario.create","action":"Seracademico\Http\Controllers\CalendarioController@create"},{"host":null,"methods":["POST"],"uri":"serbinario\/calendario\/store","name":"serbinario.calendario.store","action":"Seracademico\Http\Controllers\CalendarioController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/calendario\/edit\/{id}","name":"serbinario.calendario.edit","action":"Seracademico\Http\Controllers\CalendarioController@edit"},{"host":null,"methods":["POST"],"uri":"serbinario\/calendario\/update\/{id}","name":"serbinario.calendario.update","action":"Seracademico\Http\Controllers\CalendarioController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/calendario\/calendarios\/{id}","name":"serbinario.calendario.calendarios","action":"Seracademico\Http\Controllers\CalendarioController@getCalendarioByMedico"},{"host":null,"methods":["POST"],"uri":"serbinario\/calendario\/calendariodata","name":"serbinario.calendario.calendariodata","action":"Seracademico\Http\Controllers\CalendarioController@findCalendarioData"},{"host":null,"methods":["POST"],"uri":"serbinario\/calendario\/calendariodatamedico","name":"serbinario.calendario.calendariodatamedico","action":"Seracademico\Http\Controllers\CalendarioController@findCalendarioDataMedico"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/agendamento\/index","name":"serbinario.agendamento.index","action":"Seracademico\Http\Controllers\AgendamentoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/agendamento\/index\/loc\/{loc}\/esp\/{esp}","name":"serbinario.agendamento.index","action":"Seracademico\Http\Controllers\AgendamentoController@index"},{"host":null,"methods":["POST"],"uri":"serbinario\/agendamento\/calendarMedico","name":"serbinario.agendamento.calendar","action":"Seracademico\Http\Controllers\AgendamentoController@calendarMedico"},{"host":null,"methods":["POST"],"uri":"serbinario\/agendamento\/loadCalendar","name":"serbinario.agendamento.loadCalendar","action":"Seracademico\Http\Controllers\AgendamentoController@loadCalendar"},{"host":null,"methods":["POST"],"uri":"serbinario\/agendamento\/store","name":"serbinario.agendamento.store","action":"Seracademico\Http\Controllers\AgendamentoController@store"},{"host":null,"methods":["POST"],"uri":"serbinario\/agendamento\/edit\/{id}","name":"serbinario.agendamento.edit","action":"Seracademico\Http\Controllers\AgendamentoController@edit"},{"host":null,"methods":["POST"],"uri":"serbinario\/agendamento\/update\/{id}","name":"serbinario.agendamento.update","action":"Seracademico\Http\Controllers\AgendamentoController@update"},{"host":null,"methods":["POST"],"uri":"serbinario\/agendamento\/delete\/{id}","name":"serbinario.agendamento.delete","action":"Seracademico\Http\Controllers\AgendamentoController@delete"},{"host":null,"methods":["POST"],"uri":"serbinario\/agendamento\/getTipoOperacao","name":"serbinario.agendamento.getTipoOperacao","action":"Seracademico\Http\Controllers\AgendamentoController@getTipoOperacao"},{"host":null,"methods":["POST"],"uri":"serbinario\/agendamento\/getGrupoOperacao\/{id}","name":"serbinario.agendamento.getGrupoOperacao","action":"Seracademico\Http\Controllers\AgendamentoController@getGrupoOperacao"},{"host":null,"methods":["POST"],"uri":"serbinario\/agendamento\/getPacientes","name":"serbinario.agendamento.getPacientes","action":"Seracademico\Http\Controllers\AgendamentoController@getPacientes"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/fila\/index","name":"serbinario.fila.index","action":"Seracademico\Http\Controllers\FilaController@index"},{"host":null,"methods":["POST"],"uri":"serbinario\/fila\/all","name":"serbinario.fila.all","action":"Seracademico\Http\Controllers\FilaController@all"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/fila\/grid","name":"serbinario.fila.grid","action":"Seracademico\Http\Controllers\FilaController@grid"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/fila\/create","name":"serbinario.fila.create","action":"Seracademico\Http\Controllers\FilaController@create"},{"host":null,"methods":["POST"],"uri":"serbinario\/fila\/store","name":"serbinario.fila.store","action":"Seracademico\Http\Controllers\FilaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/fila\/edit\/{id}","name":"serbinario.fila.edit","action":"Seracademico\Http\Controllers\FilaController@edit"},{"host":null,"methods":["POST"],"uri":"serbinario\/fila\/update\/{id}","name":"serbinario.fila.update","action":"Seracademico\Http\Controllers\FilaController@update"},{"host":null,"methods":["POST"],"uri":"serbinario\/fila\/getDadosPaciente","name":"serbinario.fila.getDadosPaciente","action":"Seracademico\Http\Controllers\FilaController@getDadosDoPaciente"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/user\/index","name":"serbinario.user.index","action":"Seracademico\Http\Controllers\UserController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/user\/grid","name":"serbinario.user.grid","action":"Seracademico\Http\Controllers\UserController@grid"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/user\/create","name":"serbinario.user.create","action":"Seracademico\Http\Controllers\UserController@create"},{"host":null,"methods":["POST"],"uri":"serbinario\/user\/store","name":"serbinario.user.store","action":"Seracademico\Http\Controllers\UserController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/user\/edit\/{id}","name":"serbinario.user.edit","action":"Seracademico\Http\Controllers\UserController@edit"},{"host":null,"methods":["POST"],"uri":"serbinario\/user\/update\/{id}","name":"serbinario.user.update","action":"Seracademico\Http\Controllers\UserController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/role\/index","name":"serbinario.role.index","action":"Seracademico\Http\Controllers\RoleController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/role\/grid","name":"serbinario.role.grid","action":"Seracademico\Http\Controllers\RoleController@grid"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/role\/create","name":"serbinario.role.create","action":"Seracademico\Http\Controllers\RoleController@create"},{"host":null,"methods":["POST"],"uri":"serbinario\/role\/store","name":"serbinario.role.store","action":"Seracademico\Http\Controllers\RoleController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"serbinario\/role\/edit\/{id}","name":"serbinario.role.edit","action":"Seracademico\Http\Controllers\RoleController@edit"},{"host":null,"methods":["POST"],"uri":"serbinario\/role\/update\/{id}","name":"serbinario.role.update","action":"Seracademico\Http\Controllers\RoleController@update"},{"host":null,"methods":["POST"],"uri":"serbinario\/util\/search","name":"serbinario.util.search","action":"Seracademico\Http\Controllers\UtilController@search"},{"host":null,"methods":["POST"],"uri":"serbinario\/util\/searchOperacoes","name":"serbinario.util.searchOperacoes","action":"Seracademico\Http\Controllers\UtilController@searchOperacoes"},{"host":null,"methods":["POST"],"uri":"serbinario\/util\/select2","name":"serbinario.util.select2","action":"Seracademico\Http\Controllers\UtilController@queryByselect2"},{"host":null,"methods":["POST"],"uri":"serbinario\/util\/select2Agenda","name":"serbinario.util.select2Agenda","action":"Seracademico\Http\Controllers\UtilController@queryByselect2Agenda"}],
            prefix: '/MarcConsulta/public/index.php',

            route : function (name, parameters, route) {
                route = route || this.getByName(name);

                if ( ! route ) {
                    return undefined;
                }

                return this.toRoute(route, parameters);
            },

            url: function (url, parameters) {
                parameters = parameters || [];

                var uri = url + '/' + parameters.join('/');

                return this.getCorrectUrl(uri);
            },

            toRoute : function (route, parameters) {
                var uri = this.replaceNamedParameters(route.uri, parameters);
                var qs  = this.getRouteQueryString(parameters);

                return this.getCorrectUrl(uri + qs);
            },

            replaceNamedParameters : function (uri, parameters) {
                uri = uri.replace(/\{(.*?)\??\}/g, function(match, key) {
                    if (parameters.hasOwnProperty(key)) {
                        var value = parameters[key];
                        delete parameters[key];
                        return value;
                    } else {
                        return match;
                    }
                });

                // Strip out any optional parameters that were not given
                uri = uri.replace(/\/\{.*?\?\}/g, '');

                return uri;
            },

            getRouteQueryString : function (parameters) {
                var qs = [];
                for (var key in parameters) {
                    if (parameters.hasOwnProperty(key)) {
                        qs.push(key + '=' + parameters[key]);
                    }
                }

                if (qs.length < 1) {
                    return '';
                }

                return '?' + qs.join('&');
            },

            getByName : function (name) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].name === name) {
                        return this.routes[key];
                    }
                }
            },

            getByAction : function(action) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].action === action) {
                        return this.routes[key];
                    }
                }
            },

            getCorrectUrl: function (uri) {
                var url = this.prefix + '/' + uri.replace(/^\/?/, '');

                if(!this.absolute)
                    return url;

                return this.rootUrl.replace('/\/?$/', '') + url;
            }
        };

        var getLinkAttributes = function(attributes) {
            if ( ! attributes) {
                return '';
            }

            var attrs = [];
            for (var key in attributes) {
                if (attributes.hasOwnProperty(key)) {
                    attrs.push(key + '="' + attributes[key] + '"');
                }
            }

            return attrs.join(' ');
        };

        var getHtmlLink = function (url, title, attributes) {
            title      = title || url;
            attributes = getLinkAttributes(attributes);

            return '<a href="' + url + '" ' + attributes + '>' + title + '</a>';
        };

        return {
            // Generate a url for a given controller action.
            // laroute.action('HomeController@getIndex', [params = {}])
            action : function (name, parameters) {
                parameters = parameters || {};

                return routes.route(name, parameters, routes.getByAction(name));
            },

            // Generate a url for a given named route.
            // laroute.route('routeName', [params = {}])
            route : function (route, parameters) {
                parameters = parameters || {};

                return routes.route(route, parameters);
            },

            // Generate a fully qualified URL to the given path.
            // laroute.route('url', [params = {}])
            url : function (route, parameters) {
                parameters = parameters || {};

                return routes.url(route, parameters);
            },

            // Generate a html link to the given url.
            // laroute.link_to('foo/bar', [title = url], [attributes = {}])
            link_to : function (url, title, attributes) {
                url = this.url(url);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given route.
            // laroute.link_to_route('route.name', [title=url], [parameters = {}], [attributes = {}])
            link_to_route : function (route, title, parameters, attributes) {
                var url = this.route(route, parameters);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given controller action.
            // laroute.link_to_action('HomeController@getIndex', [title=url], [parameters = {}], [attributes = {}])
            link_to_action : function(action, title, parameters, attributes) {
                var url = this.action(action, parameters);

                return getHtmlLink(url, title, attributes);
            }

        };

    }).call(this);

    /**
     * Expose the class either via AMD, CommonJS or the global object
     */
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return laroute;
        });
    }
    else if (typeof module === 'object' && module.exports){
        module.exports = laroute;
    }
    else {
        window.laroute = laroute;
    }

}).call(this);

