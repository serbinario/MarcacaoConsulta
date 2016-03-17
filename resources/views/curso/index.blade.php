@extends('menu')

@section('content')
    <div class="ibox float-e-margins">

        <div class="ibox-title">
            <div class="col-md-10">
                <h4>
                    <i class="fa fa-users"></i>
                    Listar Cursos
                </h4>
            </div>
            <div class="col-md-2">
                <a href="{{ route('seracademico.curso.create')}}" class="btn-sm btn-primary">Novo Curso</a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="sala-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Sede</th>
                                <th>Tipo do Curso</th>
                                <th >Acão</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Sede</th>
                                <th>Tipo do Curso</th>
                                <th style="width: 10%;">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="ibox-footer">
            <span class="pull-right">
                The righ side of the footer
            </span>
            This is simple footer example
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">
        var table = $('#sala-grid').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('seracademico.curso.grid') !!}",
            columns: [
                {data: 'nome', name: 'fac_cursos.nome'},
                {data: 'sede', name: 'sedes.nome'},
                {data: 'tipocurso', name: 'tipocurso.nome'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@stop