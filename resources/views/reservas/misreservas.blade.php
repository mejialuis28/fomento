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
                        <div class="form-group">
                            <a class="btn btn-primary" href="{{ url('reservas/create') }}"><i class="glyphicon glyphicon-plus"></i> Nueva reserva</a>
                        </div>

                        <table class="table table-condensed table-bordered">
                            <thead>
                            <tr class="success">
                                <th>Código</th>
                                <th>Fecha Reserva</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reservas as $reserva)
                                <tr>
                                    <td>{{ $reserva->id }}</td>
                                    <td>{{ $reserva->created_at->format('d/m/Y h:i A') }}</td>
                                    <td>{{ $reserva->fechaInicio->format('d/m/Y h:i A') }}</td>
                                    <td>{{ $reserva->fechaFin->format('d/m/Y h:i A') }}</td>
                                    <td>{{ $reserva->estado }}</td>
                                    <td class="text-center">
                                        <button onclick="verDetalle('{{url('reservas/misreservas/details')}}/{{ $reserva->id }}')" class="btn btn-grey btn-sm"><i class="glyphicon glyphicon-list"></i></button>
                                        @if($reserva->estado == 'Creada')
                                            <button onclick="cancelarReserva(this)" class="btn btn-red btn-sm" data-cancel-id="{{$reserva->id}}"><i class="glyphicon glyphicon-remove"></i></button>
                                        @endif
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
            <div role="tabpanel" class="tab-pane" id="prestamos">
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
                                <th>Estado</th>
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
                                    <td>{{ $prestamo->estado }}</td>
                                    <td class="text-center">
                                        <button onclick="verDetallePrestamo('{{url('prestamos/details')}}/{{ $prestamo->id }}')" class="btn btn-grey btn-sm"><i class="glyphicon glyphicon-list"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="text-center">
                            <?php echo $prestamos->appends(Request::except('pageh'))->render(); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

     <!-- Modal -->
    <div class="modal fade" id="mdlDetalle" tabindex="-1" role="dialog" aria-labelledby="mdlTitulo" aria-hidden="true">
        <div id="dialogo" class="modal-dialog">
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


    <div class="modal fade" id="mdlDetallePrestamo" tabindex="-1" role="dialog" aria-labelledby="mdlTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="mdlTitle">Detalle del préstamo</h5>
                </div>
                <div class="modal-body">
                    <div id="resultado">

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
            $('#mdlDetallePrestamo').on('hidden.bs.modal', function () {
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

        function verDetallePrestamo(url) {
            $.ajax({
                url: url,
                type: 'GET',
                error: function () {
                    $('#resultado').html("<p class='bg-danger'>Se presentó un error al consultar la información. Cierre la ventana e intente nuevamente.</p>");
                },
                success: function (data) {
                    $('#resultado').html(data);
                }
            });
            $('#mdlDetallePrestamo').appendTo("body").modal('show');
        }

        function cancelarReserva(element){
            var cancelId = element.getAttribute('data-cancel-id');
            if(confirm('¿Está seguro de cancelar la reserva?'))
            {
                var form =
                        $('<form>', {
                            'method': 'POST',
                            'action': "{{url('reservas/misreservas/cancelar')}}" + '/' + cancelId
                        });
                var token =
                        $('<input>', {
                            'type': 'hidden',
                            'name': '_token',
                            'value': '{{csrf_token()}}'
                        });
                var method =
                    $('<input>', {
                        'name': '_method',
                        'type': 'hidden',
                        'value': 'DELETE'
                    });
                form.append(token, method).appendTo('body');
                form.submit();
            }
        }
    </script>

@endsection