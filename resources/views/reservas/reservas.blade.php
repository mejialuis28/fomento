@extends('master')

@section('css')

@endsection

@section('content')
    <div role="tabpanel">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#reservas" aria-controls="reservas" role="tab" data-toggle="tab">Reservas Activas</a></li>
            <li role="presentation"><a href="#historial" aria-controls="historial" role="tab" data-toggle="tab">Historial Reservas</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="reservas">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Listado de reservas activas</h4>
                    </div>

                    <div class="panel-body">
                        <table class="table table-condensed table-bordered">
                            <thead>
                            <tr class="success">
                                <th>Código</th>
                                <th>Responsable</th>
                                <th>Documento</th>
                                <th>Fecha Reserva</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reservas as $reserva)
                                <tr>
                                    <td>{{ $reserva->id }}</td>
                                    <td>{{ $reserva->user->nombres }} {{ $reserva->user->apellidos }}</td>
                                    <td>{{ $reserva->user->documento }}</td>
                                    <td>{{ $reserva->created_at->format('d/m/Y h:i A') }}</td>
                                    <td>{{ $reserva->fechaInicio->format('d/m/Y h:i A') }}</td>
                                    <td>{{ $reserva->fechaFin->format('d/m/Y h:i A') }}</td>
                                    <td class="text-center">
                                        <button onclick="verDetalle('{{url('reservas/misreservas/details')}}/{{ $reserva->id }}')" class="btn btn-grey btn-sm"><i class="glyphicon glyphicon-list"></i></button>
                                        <a class="btn btn-default btn-sm" href="{{ url('prestamos/create?reserva=').$reserva->id }}"><i class="glyphicon glyphicon-check"></i> Préstamo</a>
                                        <button onclick="modalRechazo(this)" class="btn btn-red btn-sm" data-rechazo-id="{{$reserva->id}}"><i class="glyphicon glyphicon-remove"></i> Rechazar</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="text-center">
                            <?php echo $reservas->appends(Request::except('page'))->render(); ?>
                        </div>

                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="historial">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <h4 class="panel-title">Historial de reservas</h4>
                    </div>

                    <div class="panel-body">
                        <table class="table table-condensed table-bordered">
                            <thead>
                            <tr class="success">
                                <th>Código</th>
                                <th>Responsable</th>
                                <th>Documento</th>
                                <th>Fecha Reserva</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($historial as $reserva)
                                <tr>
                                    <td>{{ $reserva->id }}</td>
                                    <td>{{ $reserva->user->nombres }} {{ $reserva->user->apellidos }}</td>
                                    <td>{{ $reserva->user->documento }}</td>
                                    <td>{{ $reserva->created_at->format('d/m/Y h:i A') }}</td>
                                    <td>{{ $reserva->fechaInicio->format('d/m/Y h:i A') }}</td>
                                    <td>{{ $reserva->fechaFin->format('d/m/Y h:i A') }}</td>
                                    <td>{{ $reserva->estado }}</td>
                                    <td class="text-center">
                                        <button onclick="verDetalle('{{url('reservas/misreservas/details')}}/{{ $reserva->id }}')" class="btn btn-grey btn-sm"><i class="glyphicon glyphicon-list"></i></button>
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
                    <h5 class="modal-title" id="mdlTitulo">Detalle de reserva</h5>
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

    <!-- Modal Rechazo -->
    <div class="modal fade" id="mdlRechazo" tabindex="-1" role="dialog" aria-labelledby="mdlTitle" aria-hidden="true">
        <div  class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="mdlTitle">Rechazo de solicitud</h5>
                </div>
                <div class="modal-body">
                    <div>
                        {!! Form::open(['method' => 'POST', 'url' => '/reservas/rechazar/', 'id' => 'frmRechazo']) !!}
                        <input type="hidden" name="idReserva" id="idReserva">
                        <label for="txtMotivo" class="control-label">Motivo del Rechazo</label>
                        <textarea id="txtMotivo" name="motivo" class="form-control" required/></textarea>
                        {!! Form::close()!!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" onclick="enviarFormRechazo()"><i class="glyphicon glyphicon-floppy-remove"></i> Aceptar</button>
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
            $('#mdlRechazo').on('hidden.bs.modal', function () {
                $('#txtMotivo').val('');
            });
        });

        function enviarFormRechazo() {
            $('#frmRechazo').submit();
        }

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

        function modalRechazo(element){
            var rechazoId = element.getAttribute('data-rechazo-id');
            $('#idReserva').val(rechazoId);
            $('#mdlRechazo').appendTo('body').modal('show');
        }

    </script>

@endsection