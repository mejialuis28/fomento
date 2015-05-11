@extends('master')

@section('css')

@endsection

@section('content')
    <div role="tabpanel">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#prestamos" aria-controls="prestamos" role="tab" data-toggle="tab">Préstamos Activos</a></li>
            <li role="presentation"><a href="#historial" aria-controls="historial" role="tab" data-toggle="tab">Historial Préstamos</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="prestamos">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Listado de préstamos activos</h4>
                    </div>

                    <div class="panel-body">
                        <table class="table table-condensed table-bordered">
                            <thead>
                            <tr class="success">
                                <th>Código</th>
                                <th>Responsable</th>
                                <th>Documento</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Entregado Por</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($prestamos as $prestamo)
                                <tr>
                                    <td>{{ $prestamo->id }}</td>
                                    <td>{{ $prestamo->user->nombres }} {{ $prestamo->user->apellidos }}</td>
                                    <td>{{ $prestamo->user->documento }}</td>
                                    <td>{{ $prestamo->fechaInicio->format('d/m/Y h:i A') }}</td>
                                    <td>{{ $prestamo->fechaFin->format('d/m/Y h:i A') }}</td>
                                    <td>{{ $prestamo->entrego->nombres.' '.$prestamo->entrego->apellidos }}</td>
                                    <td class="text-center">
                                        <button onclick="verDetalle('{{url('prestamos/details')}}/{{ $prestamo->id }}')" class="btn btn-grey btn-sm"><i class="glyphicon glyphicon-list"></i></button>
                                        <a class="btn btn-default btn-sm" href="{{ url('prestamos/devolucion?prestamo=').$prestamo->id }}"><i class="glyphicon glyphicon-chevron-left"></i> Devolución</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="text-center">
                            <?php echo $prestamos->appends(Request::except('page'))->render(); ?>
                        </div>

                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="historial">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <h4 class="panel-title">Historial de préstamos</h4>
                    </div>

                    <div class="panel-body">
                        <table class="table table-condensed table-bordered">
                            <thead>
                            <tr class="success">
                                <th>Código</th>
                                <th>Responsable</th>
                                <th>Documento</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Recibido Por</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($historial as $prestamo)
                                <tr>
                                    <td>{{ $prestamo->id }}</td>
                                    <td>{{ $prestamo->user->nombres }} {{ $prestamo->user->apellidos }}</td>
                                    <td>{{ $prestamo->user->documento }}</td>
                                    <td>{{ $prestamo->fechaInicio->format('d/m/Y h:i A') }}</td>
                                    <td>{{ $prestamo->fechaFin->format('d/m/Y h:i A') }}</td>
                                    <td>{{ $prestamo->recibio->nombres.' '.$prestamo->recibio->apellidos }}</td>
                                    <td class="text-center">
                                        <button onclick="verDetalle('{{url('prestamos/details')}}/{{ $prestamo->id }}')" class="btn btn-grey btn-sm"><i class="glyphicon glyphicon-list"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            <?php echo $historial->appends(Request::except('pageh'))->render(); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="mdlDetalle" tabindex="-1" role="dialog" aria-labelledby="mdlTitulo" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="mdlTitulo">Detalle del préstamo</h5>
                </div>
                <div class="modal-body">
                    <div id="result">

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-red" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')



    <script type="text/javascript">
        $( document ).ready(function() {
            $('#mdlDetalle').on('hidden.bs.modal', function () {
                $('#result').html('');
            });
        });

        function verDetalle(url) {
            $.ajax({
                url: url,
                type: 'GET',
                error: function () {
                    $('#result').html("<p class='bg-danger'>Se presentó un error al consultar la información. Cierre la ventana e intente nuevamente.</p>");
                },
                success: function (data) {
                    $('#result').html(data);
                }
            });
            $('#mdlDetalle').appendTo("body").modal('show');
        }

    </script>

@endsection