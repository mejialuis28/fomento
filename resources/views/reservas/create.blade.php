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
                                <input id="txtResp" name="responsable" class="form-control" type="text" value="{{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}" disabled />
                            </div>
                            <label for="txtDescripcion" class="col-md-2 control-label">Documento</label>
                            <div class="col-md-4">
                                <input id="txtDocumento" name="documento" class="form-control" value="{{ Auth::user()->documento }}" type="text" disabled />
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtFecha" class="col-md-2 control-label">Fecha reserva</label>
                            <div class="col-md-4">
                                <input id="txtFecha" name="fechaIngreso" data-date-format="dd/mm/yyyy" class="form-control" required type="text" placeholder=" dd/mm/aaaa"/>
                            </div>
                            <label  class="col-md-2 control-label">Hora inicial y final</label>
                            <div class="col-md-2">
                                <div class="input-group bootstrap-timepicker">
                                    <input id="horaIni" type="text" class="form-control" />
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group bootstrap-timepicker">
                                    <input id="horaFin" type="text" class="form-control" />
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtComentario" class="col-md-2 control-label">Comentarios</label>
                            <div class="col-md-10">
                                <textarea id="txtComentario" rows="3" name="comentarios" required class="form-control" placeholder="Comentarios"></textarea>
                            </div>
                        </div>
                    </div>
                     <hr>
                    <div>
                        <h5 class="text-center"><strong>Listado de artículos de la reserva</strong></h5>

                        <div >
                            <button class="btn btn-default" onclick="abrirModalNuevo(); return false;"><i class="glyphicon glyphicon-plus"></i> Nuevo item</button>
                        </div>
                        </br>
                        <table class="table table-condensed table-bordered">
                            <thead>
                            <tr class="success">
                                <th>Placa</th>
                                <th>Descripción</th>
                                <th>Categoria</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                        <div >
                            <button class="btn btn-default" onclick="abrirModalNuevo(); return false;"><i class="glyphicon glyphicon-plus"></i> Nuevo item</button>
                        </div>
                    </div>                    
                    <hr>
                    <div>
                        <div class="text-center">
                            <button class="btn btn-default"><i class="glyphicon glyphicon-floppy-disk"></i> Enviar</button>
                            <a href="{{Url('misreservas')}}" class="btn btn-red"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div> 

    <div class="modal fade" id="mdlNuevo" tabindex="-1" role="dialog" aria-labelledby="mdlTitulo" aria-hidden="true">
        <div id="dialogo" class="modal-dialog" style="width:70%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="mdlTitulo">Agregar item a reserva</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::open(['id' => 'frmBuscar']) !!}
                            <label for="txtCat" class="control-label col-md-2">Categoría</label>
                            <div class="col-md-3">
                                <select class="form-control"  name="cat" id="txtCat" onchange="$(this).closest('form').submit()">
                                    <option value="0">-Todas-</option>
                                    @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>                                    
                                    @endforeach
                                </select>
                            </div>
                            <label for="txtCat" class="control-label col-md-2">Descripción</label>
                            <div class="col-md-3">
                                <input id="txtDesc" type="text" name="descripcion" class="form-control" />
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                            </div>
                        {!! Form::close()!!}
                    </div>
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
    <!-- tomado de http://www.eyecon.ro/bootstrap-datepicker/ -->
    <script src="{{asset('js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <!-- tomado de http://jdewit.github.io/bootstrap-timepicker -->
    <script src="{{asset('js/timepicker.js')}}" type="text/javascript"></script>

    <script type="text/javascript">


        var items = null;


        $(document).ready(function() {
            // Inicializa items con un array vacío
            items = [];            

            // Inicializa time picker de hora inicial
            $('#horaIni').timepicker({
                showInputs : false                
            });
            // Inicializa time picker de hora final
            $('#horaFin').timepicker({
                showInputs : false                
            });
            // Inicializa date picker para la fecha de reserva.
            $('#txtFecha').datepicker();

            $("#frmBuscar").submit(function() {
                
                $.ajax({
                    url: '{{url('reservas/buscaritems')}}',
                    type: 'POST',
                    data: $(this).serialize(),
                    error: function () {
                        $('#result').html("<div><p class='bg-danger'>" +
                        "Se presentó un error al consultar la información. Cierre la ventana e intente nuevamente.</p></div>");
                    },
                    success: function (data) {
                        $('#result').html(data);
                    }
                });
                return false;
            });
        });

        function abrirModalNuevo() {
            $('#mdlNuevo').appendTo("body").modal('show');
            return false;
        }    

    </script>
@endsection