@extends('master')

@section('css')
    <link href="{{ asset('css/datepicker.css') }}" media="all" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Filtros - Reporte de Indicadores.</h4>
        </div>
        <div class="panel-body">
            {!! Form::open(['method' => 'GET', 'class' => 'form-horizontal']) !!}
                <fieldset>
                    <div>
                        <div class="form-group">
                            <label for="txtFechaIni" class="col-md-2 control-label">Fecha Inicio</label>
                            <div class="col-md-3">
                                <input id="txtFechaIni" name="ini" data-date-format="dd/mm/yyyy" class="form-control" value="{{ $input['ini'] }}" required type="text" placeholder="d/m/a">
                            </div>

                            <label for="txtFechaFin" class="col-md-2 control-label">Fecha Fin</label>
                            <div class="col-md-3">
                                <input id="txtFechaFin" name="fin" data-date-format="dd/mm/yyyy" class="form-control"  value="{{ $input['fin'] }}" required type="text" placeholder="d/m/a">
                            </div>
                            <button class="btn btn-default">Generar</button>
                        </div>
                    </div>

                </fieldset>
            {!! Form::close() !!}
        </div>
    </div>

    @if(isset($indicadores))
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default ">
                <div class="panel-heading">
                    <h4 class="panel-title">Cantidad de reservas y préstamos</h4>
                </div>
                <div class="panel-body">
                    <div>
                    <canvas  id="barras">
                    </canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Cantidad de préstamos por tipo de usuario</h4>
                </div>
                <div class="panel-body">
                    <div>
                    <canvas  id="barras2">
                    </canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Cantidad de préstamos por categoría instrumento</h4>
                </div>
                <div class="panel-body">
                    <div style="text-align: center">
                        <canvas  id="pie" height="300" style="height: 300px;" >
                        </canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection
@section('scripts')

    <!-- tomado de http://www.eyecon.ro/bootstrap-datepicker/ -->
    <script src="{{asset('js/bootstrap-datepicker.js')}}" type="text/javascript"></script>

    <script src="{{asset('js/Chart.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Inicializa date picker para la fecha inicial.
            $('#txtFechaIni').datepicker();

            // Inicializa date picker para la fecha final.
            $('#txtFechaFin').datepicker();
        });

        @if(isset($indicadores))

        var barChartData = {
            labels : ["Reservas Totales","Préstamos Totales","Préstamos con reserva","Péstamos sin reserva","Préstamos sin devolución"],
            datasets : [
                {
                    fillColor : "rgba(151,187,205,0.5)",
                    strokeColor : "rgba(151,187,205,0.8)",
                    highlightFill : "rgba(151,187,205,0.75)",
                    highlightStroke : "rgba(151,187,205,1)",
                    data : [{{ $indicadores['totales']['reservas'] }},{{ $indicadores['totales']['prestamos'] }},
                        {{ $indicadores['totales']['prestamosConReserva'] }},{{ $indicadores['totales']['prestamosSinReserva'] }},
                        {{ $indicadores['totales']['prestamosSinDevolucion'] }}]
                }
            ]

        }


        var label = [];
        var datos = [];
        @foreach($indicadores['prestamosPorUsuario'] as $dato)
            label.push('{{ $dato->tipo }}');
            datos.push({{ $dato->cantidad }})
        @endforeach

        var barChartData2 = {
            labels : label,
            datasets : [
                {
                    fillColor : "rgba(151,187,205,0.5)",
                    strokeColor : "rgba(151,187,205,0.8)",
                    highlightFill : "rgba(151,187,205,0.75)",
                    highlightStroke : "rgba(151,187,205,1)",
                    data : datos
                }
            ]

        }

        var colores = ['#F7464A','#46BFBD','#FDB45C','#949FB1','','','','','','']
        var highlights = ['#FF5A5E','#5AD3D1','#FFC870','#A8B3C5','','','','','','']
        var pieData = [];
        var cont = 0;

        @foreach($indicadores['prestamosPorCategoria'] as $dato)
            pieData.push({value: {{ $dato->cantidad }}, color: colores[cont], highlight: highlights[cont], label: '{{ $dato->categoria }}'})
            cont++;
        @endforeach
        window.onload = function(){
            var ctx = document.getElementById("barras").getContext("2d");
            window.myBar = new Chart(ctx).Bar(barChartData, {
                responsive : true
            });

            var ctx2 = document.getElementById("barras2").getContext("2d");
            window.myBar2 = new Chart(ctx2).Bar(barChartData2, {
                responsive : true
            });

            var ctx3 = document.getElementById("pie").getContext("2d");
            window.myPie = new Chart(ctx3).Pie(pieData);
        }
        @endif

    </script>
@endsection
