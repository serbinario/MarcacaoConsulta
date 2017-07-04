@extends('menu')

@section('content')

    <section id="content">
        <div class="container">

            <div class="mini-charts">
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <a href="#">
                            <div class="mini-charts-item bgm-cyan ">
                                <div class="clearfix">
                                    <div class=""></div>
                                    <div class="count">
                                        <small>Pessoas na fila</small>
                                        <h2>{{$fila->qtd}}</h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <a href="#">
                            <div class="mini-charts-item bgm-orange">
                                <div class="clearfix">
                                    <div class=""></div>
                                    <div class="count">
                                        <small>Aguardando atendimento</small>
                                        <h2>{{$aguardando->qtd}}</h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <a href="#">
                            <div class="mini-charts-item bgm-lightgreen">
                                <div class="clearfix">
                                    <div class=""></div>
                                    <div class="count">
                                        <small>Pacientes atendido</small>
                                        <h2>{{$atendidos->qtd}}</h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <a href="#">
                            <div class="mini-charts-item bgm-red">
                                <div class="clearfix">
                                    <div class=""></div>
                                    <div class="count">
                                        <small>Pacientes não atendido</small>
                                        <h2>{{$naoAtendidos->qtd}}</h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-12-md">
                                    <div id="container-1" style=" margin: 0 auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-12-md">
                                    <div id="container-2" style=" margin: 0 auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-12-md">
                                    <div id="container-3" style=" margin: 0 auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{--<div class="col-md-6">
                    <div class="card">
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-6-md">
                                    <div id="container-2" style=" margin: 0 auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>--}}
            </div>

        </div>
    </section>
@stop

@section('javascript')
    <script src="{{ asset('/js/dashboard/index.js')  }}"></script>
@stop