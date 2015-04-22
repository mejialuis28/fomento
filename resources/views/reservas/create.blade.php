@extends('master')


@section('css')
    <link href="{{ asset('css/datepicker.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/timepicker.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Nueva reserva</h4>
        </div>
        <div class="panel-body">
            <form method="POST" class="form-horizontal" action="create">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <fieldset>
                    <div>
                        <div class="form-group">
                            <label for="txtResp" class="col-md-2 control-label">Responsable</label>
                            <div class="col-md-4">
                                <input id="txtResp" name="responsable" class="form-control disabled" type="text"/>
                            </div>
                            <label for="txtDescripcion" class="col-md-2 control-label">Documento</label>
                            <div class="col-md-4">
                                <input id="txtDocumento" name="documento" class="form-control disabled" type="text"/>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtFecha" class="col-md-2 control-label">Fecha</label>
                            <div class="col-md-4">
                                <input id="txtFecha" name="fechaIngreso" data-date-format="dd/mm/yyyy" class="form-control" required type="text" placeholder=" dd/mm/aaaa"/>
                            </div>
                            <label  class="col-md-2 control-label">Hora</label>
                            <div class="col-md-2">
                                <div class="input-append bootstrap-timepicker">
                                    <input id="horaIni" type="text" class="input-small">
                                    <span class="add-on"><i class="icon-time"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-append bootstrap-timepicker">
                                    <input id="horaFin" type="text" class="input-small">
                                    <span class="add-on"><i class="icon-time"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtComentario" class="col-md-2 control-label">Comentarios</label>
                            <div class="col-md-10">
                                <textarea id="txtComentario" name="comentarios" required class="form-control" placeholder="Comentarios"></textarea>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <div class="col-md-offset-2">
                            <button class="btn btn-default"><i class="glyphicon glyphicon-floppy-disk"></i> Guardar</button>
                            <a href="{{Url('reservas')}}" class="btn btn-red"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- tomado de http://www.eyecon.ro/bootstrap-datepicker/ -->
    <script src="{{asset('js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <!-- tomado de http://jdewit.github.io/bootstrap-timepicker -->
    <script src="{{asset('js/timepicker.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
        $('#horaIni').timepicker();
        $('#horaFin').timepicker();
    </script>
@endsection