@extends('master')

@section('css')
    <link href="{{ asset('css/datepicker.css') }}" media="all" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Filtros - Reporte de Préstamos</h4>
        </div>
        <div class="panel-body">
            {!! Form::open(['method' => 'GET', 'class' => 'form-horizontal']) !!}
                <fieldset>
                    <div>
                        <div class="form-group">
                            <label for="txtFechaIni" class="col-md-2 control-label">Fecha Inicio</label>
                            <div class="col-md-4">
                                <input id="txtFechaIni" name="ini" data-date-format="dd/mm/yyyy" class="form-control" value="{{ $input['ini'] }}" required type="text" placeholder="d/m/a">
                            </div>

                            <label for="txtFechaFin" class="col-md-2 control-label">Fecha Fin</label>
                            <div class="col-md-4">
                                <input id="txtFechaFin" name="fin" data-date-format="dd/mm/yyyy" class="form-control"  value="{{ $input['fin'] }}" required type="text" placeholder="d/m/a">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtEstado" class="col-md-2 control-label">Estado</label>
                            <div class="col-md-4">
                                <select class="form-control"  name="est" id="txtEst">
                                    <option value="0">-Todos-</option>
                                    <option>Prestado</option>
                                    <option>Devuelto</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-md-offset-2">
                                <button class="btn btn-default">Generar</button>
                            </div>

                        </div>
                    </div>
                </fieldset>
            {!! Form::close() !!}
        </div>
    </div>

    @if(isset($detallesPrestamo))
    <div class="panel panel-default">

        <div class="panel-heading">
            <h4 class="panel-title">Listado de Préstamos</h4>
        </div>

        <div class="panel-body">

            <div class="form-group">
                <button class="btn btn-primary" id="exportar">Exportar</button>
            </div>

            <table class="table table-condensed table-bordered">
                <thead>
                <tr class="success">
                    <th>Código</th>
                    <th>Responsable</th>
                    <th>Documento</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Estado</th>
                    <th>Placa</th>
                    <th>Item</th>
                </tr>
                </thead>
                <tbody>
                @foreach($detallesPrestamo as $detalle)
                    <tr>
                        <td>{{ $detalle->prestamo->id }}</td>
                        <td>{{ $detalle->prestamo->user->nombres }} {{ $detalle->prestamo->user->apellidos }}</td>
                        <td>{{ $detalle->prestamo->user->documento }}</td>
                        <td>{{ $detalle->prestamo->fechaInicio->format('d/m/Y h:i A') }}</td>
                        <td>{{ $detalle->prestamo->fechaFin->format('d/m/Y h:i A') }}</td>
                        <td>{{ $detalle->prestamo->estado }}</td>
                        <td>{{ $detalle->item->placa }}</td>
                        <td>{{ $detalle->item->descripcion }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
    @endif

@endsection
@section('scripts')

    <!-- tomado de http://www.eyecon.ro/bootstrap-datepicker/ -->
    <script src="{{asset('js/bootstrap-datepicker.js')}}" type="text/javascript"></script>

    <script src="{{asset('js/jquery.table2excel.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Inicializa date picker para la fecha inicial.
            $('#txtFechaIni').datepicker();

            // Inicializa date picker para la fecha final.
            $('#txtFechaFin').datepicker();

            @if($input['est'] != '')
            $('#txtEst option:contains("{{ $input['est'] }}")').prop('selected', true)
            @endif

        });

        $('#exportar').on('click', function() {
            $(".table").table2excel({
                name: "Excel Document Name",
                filename: "prestamos"
            });
        });
    </script>
@endsection
