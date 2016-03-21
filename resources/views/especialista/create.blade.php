@extends('menu')


@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h4>
                <i class="fa fa-user"></i>
                Cadastrar Especialista
            </h4>
        </div>
        <div class="ibox-content">

            @if(Session::has('message'))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <em> {!! session('message') !!}</em>
                </div>
            @endif

            @if(Session::has('errors'))
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {!! Form::open(['route'=>'serbinario.especialista.store', 'method' => "POST", 'id' => 'formEspecialista', 'enctype' => 'multipart/form-data']) !!}
                @include('tamplatesForms.tamplateFormEspecialista')
            {!! Form::close() !!}
        </div>
    </div>

    @section('javascript')
        <script type="text/javascript">
            //consulta via select2 especialidade
            $("#especialidade").select2({
                placeholder: 'Selecione uma especialidade',
                minimumInputLength: 3,
                width: 400,
                ajax: {
                    type: 'POST',
                    url: "{{ route('serbinario.util.select2')  }}",
                    dataType: 'json',
                    delay: 250,
                    crossDomain: true,
                    data: function (params) {
                        return {
                            'search':     params.term, // search term
                            'tableName':  'especialidade',
                            'fieldName':  'nome',
                            /*'fieldWhere':  'nivel',
                            'valueWhere':  '3',*/
                            'page':       params.page
                        };
                    },
                    headers: {
                        'X-CSRF-TOKEN' : '{{  csrf_token() }}'
                    },
                    processResults: function (data, params) {

                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    }
                }
            });

            //consulta via select2 cgm
            $("#cgm").select2({
                placeholder: 'Selecione um cgm',
                minimumInputLength: 3,
                width: 400,
                ajax: {
                    type: 'POST',
                    url: "{{ route('serbinario.util.select2')  }}",
                    dataType: 'json',
                    delay: 250,
                    crossDomain: true,
                    data: function (params) {
                        return {
                            'search':     params.term, // search term
                            'tableName':  'cgm',
                            'fieldName':  'nome',
                            /*'fieldWhere':  'nivel',
                             'valueWhere':  '3',*/
                            'page':       params.page
                        };
                    },
                    headers: {
                        'X-CSRF-TOKEN' : '{{  csrf_token() }}'
                    },
                    processResults: function (data, params) {

                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    }
                }
            });
        </script>
    @stop
@stop
