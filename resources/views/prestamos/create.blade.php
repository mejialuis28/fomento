@extends('master')

@section('css')
    <link href="{{ asset('css/datepicker.css') }}" media="all" rel="stylesheet" type="text/css"
          xmlns="http://www.w3.org/1999/html"/>
    <link href="{{ asset('css/timepicker.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Ejecutar préstamo</h4>
        </div>
        <div class="panel-body">
            <form id="frmGeneral" method="POST" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <fieldset>
                    <div>
                        <div class="form-group">
                            <label for="txtResp" class="col-md-2 control-label">Responsable</label>
                            <div class="col-md-4">
                                <input id="txtResp" name="responsable" class="form-control" type="text" value="{{ $reserva->user->nombres }} {{ $reserva->user->apellidos }}" readonly />
                            </div>
                            <label for="txtDocumento" class="col-md-2 control-label">Documento</label>
                            <div class="col-md-4">
                                <input id="txtDocumento" name="documento" class="form-control" value="{{ $reserva->user->documento }}" type="text" readonly />
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtFecha" class="col-md-2 control-label">Fecha reserva</label>
                            <div class="col-md-4">
                                <input id="txtFecha" name="fecha" data-date-format="dd/mm/yyyy" class="form-control" required type="text" value="{{ $reserva->fechaInicio->format('d/m/Y') }}" readonly>
                            </div>
                            <label  class="col-md-2 control-label">Hora inicial y final</label>
                            <div class="col-md-2">
                                <div class="input-group bootstrap-timepicker">
                                    <input id="horaIni" name="horaIni" type="text" value="{{ $reserva->fechaInicio->format('h:i A') }}" class="form-control" required/>
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group bootstrap-timepicker">
                                    <input id="horaFin" name="horaFin" type="text" value="{{ $reserva->fechaFin->format('h:i A') }}" class="form-control" required/>
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtComentarioUsuario" class="col-md-2 control-label">Comentarios Reserva</label>
                            <div class="col-md-10">
                                <textarea id="txtComentarioUsuario" rows="3" name="comentariosUsuario" required class="form-control" readonly>{{ $reserva->comentarios }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtObservacionesEntrega" class="col-md-2 control-label">Comentarios Entrega</label>
                            <div class="col-md-10">
                                <textarea id="txtObservacionesEntregaEntega" rows="3" name="observacionesEntrega" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="idReserva" class="col-md-2 control-label">Código Reserva</label>
                            <div class="col-md-4">
                                <input id="idReserva" name="idReserva" class="form-control" type="text" value="{{ $reserva->id }}" readonly/>
                            </div>
                            <label for="entregadoPor" class="col-md-2 control-label">Entregado Por:</label>
                            <div class="col-md-4">
                                <select id="entregadoPor" name="entregadoPor" class="form-control">
                                    @foreach($administradores as $admin)
                                        @if($admin->user->id == Auth::user()->id)
                                            <option value="{{ $admin->user->id }}" selected>{{ $admin->user->nombres }} {{ $admin->user->apellidos }}</option>
                                        @else
                                            <option value="{{ $admin->user->id }}">{{ $admin->user->nombres }} {{ $admin->user->apellidos }}</option>
                                        @endif
                                     @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
            <hr>
            <div>
                <h5 class="text-center"><strong>Listado de artículos de la reserva</strong></h5>
                <table id='tblItems' class="table table-condensed table-bordered">
                    <thead>
                    <tr class="success">
                        <th>Placa</th>
                        <th>Descripción</th>
                        <th>Categoria</th>
                        <th>Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($reserva->items as $detalle)
                            <tr>
                                <td>{{ $detalle->item->placa }}</td>
                                <td>{{ $detalle->item->descripcion}}</td>
                                <td>{{ $detalle->item->cat->nombre}}</td>
                                <td>{{ $detalle->item->est->nombre}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>                    
            <hr>
            <div>
                <div class="text-center">
                    <button class="btn btn-default" onclick="$('#frmGeneral').submit()"><i class="glyphicon glyphicon-floppy-disk"></i> Enviar</button>
                    <a href="{{Url('reservas')}}" class="btn btn-red"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                </div>
            </div>                
        </div>
    </div> 

@endsection

@section('scripts')
    <!-- tomado de http://jdewit.github.io/bootstrap-timepicker -->
    <script src="{{asset('js/timepicker.js')}}" type="text/javascript"></script>

    <script type="text/javascript">

        $(document).ready(function() {

            // Inicializa time picker de hora inicial
            $('#horaIni').timepicker({
                showInputs : false
            });
            // Inicializa time picker de hora final
            $('#horaFin').timepicker({
                showInputs : false
            });
        });

    </script>
@endsection