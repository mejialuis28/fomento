@extends('master')

@section('css')
  
@endsection

@section('content')
    <div role="tabpanel">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#reservas" aria-controls="reservas" role="tab" data-toggle="tab">Reservas</a></li>
            <li role="presentation"><a href="#prestamos" aria-controls="prestamos" role="tab" data-toggle="tab">Préstamos</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="reservas">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <h4 class="panel-title">Listado de reservas</h4>
                    </div>

                    <div class="panel-body">
                        <table class="table table-condensed table-bordered">
                            <thead>
                            <tr class="success">
                                <th>Responsable</th>
                                <th>Documento</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Comentarios</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reservas as $reserva)
                                <tr>
                                    <td>{{ $reserva->user->nombres }} {{ $reserva->user->apellidos }}</td>
                                    <td>{{ $reserva->user->documento }}</td>
                                    <td>{{ $reserva->fechaInicio }}</td>
                                    <td>{{ $reserva->fechaFin }}</td>
                                    <td>{{ $reserva->comentarios }}</td>
                                    <td class="text-center">

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="text-center">
                        </div>

                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="prestamos">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <h4 class="panel-title">Historial de préstamos</h4>
                    </div>

                    <div class="panel-body">

                        <div class="text-center">
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')

@endsection