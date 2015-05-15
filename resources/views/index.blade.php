@extends('master')

@section('content')
    <div>
        <div class="container">
            <h2 class="text-center">Sistema de reserva de instrumentos y gestión de inventario.</h2>
            <h3 class="text-center">Laboratorio de Fomento Cultural Politecnico JIC.</h3>
            </br>
            <p class="lead">
                El sistema de reserva de instrumentos y gestión de inventario permite al laboratorio de Fomento Cultural del Politécnico Jaime Isaza Cadavid proveer a la comunidad Politécnica una opción simple para reservar instrumentos que el laboratorio ha puesto a su disposición.
            </p>
            @if(Auth::guest())
            <p class="text-center"><a href="{{ url('login') }}" class="btn btn-primary btn-lg">Ingresar &raquo;</a></p>
            @else
                @if(Auth::user()->admin)
                    @if(Auth::user()->admin->activo)
                        <div class="container">
                            <div class="row">
                                <div class="text-center">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="service-wrapper">
                                            <i style="font-size: 4em;" class="glyphicon glyphicon-calendar"></i>
                                            <h3>Administrar reservas</h3>
                                            <p>Permite administrar las reservas creadas por los usuarios.</p>
                                            <a href="{{ url('reservas') }}" class="btn">Reservas</a>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="service-wrapper">
                                            <i style="font-size: 4em;" class="glyphicon glyphicon-th-list"></i>
                                            <h3>Administrar préstamos</h3>
                                            <p>Permite administrar los préstamos que se han ejecutado.</p>
                                            <a href="{{ url('prestamos') }}" class="btn">Préstamos</a>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="service-wrapper">
                                            <i style="font-size: 4em;" class="glyphicon glyphicon-list-alt"></i>
                                            <h3>Administrar Inventario</h3>
                                            <p>Permite agregar, editar y eliminar items del inventario.</p>
                                            <a href="{{ url('inventario') }}" class="btn">Inventario</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="container">
                            <div class="row">
                                <div class="text-center">
                                    <div class="col-md-4 col-md-offset-2 col-sm-6">
                                        <div class="service-wrapper">
                                            <i style="font-size: 4em;" class="glyphicon glyphicon-calendar"></i>
                                            <h3>Mis reservas</h3>
                                            <p>Administrar mis reservar y visualizar el historial de reservas</p>
                                            <a href="{{ url('reservas/misreservas') }}" class="btn">Mis Reservas</a>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="service-wrapper">
                                            <i style="font-size: 4em;" class="glyphicon glyphicon-plus"></i>
                                            <h3>Nueva reserva</h3>
                                            <p>Permite realizar una nueva reserva en el laboratorio de Fomento Cultural.</p>
                                            <a href="{{ url('reservas/create') }}" class="btn">Nueva Reserva</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="container">
                        <div class="row">
                            <div class="text-center">
                                <div class="col-md-4 col-md-offset-2 col-sm-6">
                                    <div class="service-wrapper">
                                        <i style="font-size: 4em;" class="glyphicon glyphicon-th-list"></i>
                                        <h3>Mis reservas</h3>
                                        <p>Administrar mis reservar y visualizar el historial de reservas</p>
                                        <a href="{{ url('reservas/misreservas') }}" class="btn">Mis Reservas</a>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="service-wrapper">
                                        <i style="font-size: 4em;" class="glyphicon glyphicon-plus"></i>
                                        <h3>Nueva reserva</h3>
                                        <p>Permite realizar una nueva reserva en el laboratorio de Fomento Cultural.</p>
                                        <a href="{{ url('reservas/create') }}" class="btn">Nueva Reserva</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

        </div>
    </div>
@endsection
