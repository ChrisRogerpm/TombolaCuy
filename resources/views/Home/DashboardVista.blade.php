@extends('Shared.layout')

@section('content')
    {{--{{Auth::user()->usuario}}--}}

    <div class="row">

        @foreach($listar_juegos as $juego)

            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-heading" role="tab"
                         id="panel-collapse-{{str_replace(' ', '', $juego->nombre)}}-heading">
                        <div class="panel-title">
                            <a href="#panel-collapse-{{str_replace(' ', '', $juego->nombre)}}" class="collapsed"
                               role="button" data-toggle="collapse"
                               data-parent="#accordion" aria-expanded="true"
                               aria-controls="panel-collapse-{{str_replace(' ', '', $juego->nombre)}}">
                                <i class="icon fa fa-line-chart text-success"></i>
                                {{$juego->nombre}}
                            </a>
                        </div>
                    </div>
                    <div id="panel-collapse-{{str_replace(' ', '', $juego->nombre)}}" class="panel-collapse collapse"
                         role="tabpanel"
                         aria-labelledby="panel-collapse-{{str_replace(' ', '', $juego->nombre)}}-heading">
                        <div class="panel-body">
                            {{$juego->nombre}}
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

@endsection