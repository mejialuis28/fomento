@extends('master')

@section('css')
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Devolución préstamo</h4>
        </div>
        <div class="panel-body">
            <form id="frmGeneral" method="POST" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="idPrestamo" value="{{ $prestamo->id }}">
                <fieldset>
                    <div>
                        <div class="form-group">
                            <label for="txtResp" class="col-md-2 control-label">Responsable</label>
                            <div class="col-md-4">
                                <input id="txtResp" name="responsable" class="form-control" type="text" value="{{ $prestamo->user->nombres.' '.$prestamo->user->apellidos }}" readonly />
                            </div>
                            <label for="txtDescripcion" class="col-md-2 control-label">Documento</label>
                            <div class="col-md-4">
                                <input id="txtDocumento" name="documento" class="form-control" value="{{ $prestamo->user->documento }}" type="text" readonly />
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtFecha" class="col-md-2 control-label">Fecha préstamo</label>
                            <div class="col-md-4">
                                <input id="txtFecha" name="fecha" data-date-format="dd/mm/yyyy" class="form-control" type="text" value="{{ $prestamo->fechaInicio->format('d/m/Y') }}" readonly>
                            </div>
                            <label  class="col-md-2 control-label">Hora inicial y final</label>
                            <div class="col-md-2">
                                <div class="input-group bootstrap-timepicker">
                                    <input id="horaIni" name="horaIni" type="text" value="{{ $prestamo->fechaInicio->format('h:i A') }}" class="form-control" readonly/>
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group bootstrap-timepicker">
                                    <input id="horaFin" name="horaFin" type="text" value="{{ $prestamo->fechaFin->format('h:i A') }}" class="form-control" readonly/>
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtObservacionesEntrega" class="col-md-2 control-label">Comentarios Entrega</label>
                            <div class="col-md-10">
                                <textarea id="txtObservacionesEntrega" rows="3" name="observacionesEntrega" class="form-control"  readonly>{{ $prestamo->observacionesEntrega }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtObservacionesDevolucion" class="col-md-2 control-label">Comentarios Devolución</label>
                            <div class="col-md-10">
                                <textarea id="txtObservacionesDevolucion" rows="3" name="observacionesDevolucion" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="entregadoPor" class="col-md-2 control-label">Entregado Por:</label>
                            <div class="col-md-4">
                                <input id="entregadoPor" name="entregadoPor" class="form-control" type="text" value="{{ $prestamo->entrego->nombres.' '.$prestamo->entrego->apellidos }}" readonly/>
                            </div>
                            <label for="recibidoPor" class="col-md-2 control-label">Recibido Por:</label>
                            <div class="col-md-4">
                                <select id="recibidoPor" name="recibidoPor" class="form-control">
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
                <hr>
                <div>
                    <h5 class="text-center"><strong>Listado de artículos del préstamo</strong></h5>
                    <table id='tblItems' class="table table-condensed table-bordered">
                        <thead>
                        <tr class="success">
                            <th>Placa</th>
                            <th>Descripción</th>
                            <th>Categoria</th>
                            <th>Estado Entrega</th>
                            <th>Estado Devolución</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($prestamo->items as $detalle)
                            <tr>
                                <td>{{ $detalle->item->placa }}</td>
                                <td>{{ $detalle->item->descripcion}}</td>
                                <td>{{ $detalle->item->cat->nombre}}</td>
                                <td>{{ $detalle->estadoIni->nombre}}</td>
                                <td>
                                    <select name="{{ $detalle->idInventario }}" class="form-control">
                                        @foreach($estados as $est)
                                            @if($est->id == $detalle->estadoEntrega)
                                                <option value="{{$est->id}}" selected>{{ $est->nombre}}</option>
                                            @else
                                                <option value="{{$est->id}}">{{ $est->nombre}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
                <div>
                    <div class="text-center">
                        <button class="btn btn-default"><i class="glyphicon glyphicon-floppy-disk"></i> Enviar</button>
                        <a href="{{Url('prestamos')}}" class="btn btn-red"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')

@endsection