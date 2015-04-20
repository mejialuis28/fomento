@extends('master')

@section('css')
    <link href="{{ asset('css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/datepicker.css') }}" media="all" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Agregar item a inventario</h4>
        </div>
        <div class="panel-body">
            <form method="POST" class="form-horizontal" action="create" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <fieldset>
                    <div>
                        <div class="form-group">
                            <label for="txtPlaca" class="col-md-2 control-label">Placa</label>
                            <div class="col-md-4">
                                <input id="txtPlaca" name="placa" required class="form-control" type="number" placeholder=" Número de placa"/>
                            </div>
                            <label for="txtDescripcion" class="col-md-2 control-label">Descripción</label>
                            <div class="col-md-4">
                                <textarea id="txtDescripcion" name="descripcion" required class="form-control" placeholder=" Ingrese una descripción"></textarea>
                            </div>

                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtCategoria" class="col-md-2 control-label">Categoría</label>
                            <div class="col-md-4">
                                <select class="form-control" name="categoria" id="txtCategoria" required>
                                    @foreach($categorias as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="txtValor" class="col-md-2 control-label">Valor</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input id="txtValor" required name="valor" class="form-control" type="number" placeholder=" Valor del Item"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtMarca" class="col-md-2 control-label">Marca</label>
                            <div class="col-md-4">
                                <input id="txtMarca" name="marca" required class="form-control" type="text" placeholder=" Marca" />
                            </div>
                            <label for="txtEstado" class="col-md-2 control-label">Estado</label>
                            <div class="col-md-4">
                                <select class="form-control" name="estadoArticulo" id="txtEstado" required>
                                    @foreach($estados as $est)
                                        <option value="{{ $est->id }}">{{ $est->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtResponsable" class="col-md-2 control-label">Responsable</label>
                            <div class="col-md-4">
                                <select class="form-control" name="responsable" id="txtResponsable" required>
                                    @foreach($responsables as $resp)
                                        <option value="{{ $resp->user->id }}">{{ $resp->user->nombres }} {{ $resp->user->apellidos }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="txtFechaIngreso" class="col-md-2 control-label">Fecha Ingreso</label>
                            <div class="col-md-4">
                                <input id="txtFechaIngreso" name="fechaIngreso" data-date-format="dd/mm/yyyy" class="form-control" required type="text" placeholder=" dd/mm/aaaa"/>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtFoto" class="col-md-2 control-label">Imagen</label>
                            <div class="col-md-4">
                                <input id="txtFoto" name="foto" type="file" accept="image/*" class="file" data-show-upload="false"/>
                            </div>
                            <div class="col-md-4 col-md-offset-2">
                                <label>
                                    <input type="checkbox" name="habilitadoPrestamo" class="checkbox-inline" id="chkPrestamo"/> Habilitar para préstamo?
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <div class="col-md-offset-2">
                            <button class="btn btn-default"><i class="glyphicon glyphicon-floppy-disk"></i> Guardar</button>
                            <a href="{{Url('inventario')}}" class="btn btn-red"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/fileinput.js')}}" type="text/javascript"></script>
    <!-- tomado de http://www.eyecon.ro/bootstrap-datepicker/ -->
    <script src="{{asset('js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $('#txtFechaIngreso').datepicker();
        $("#txtFoto").fileinput({
            previewFileType: "image",
            browseLabel: " Seleccionar",
            browseIcon: '<i class="glyphicon glyphicon-picture"></i>',
            removeClass: "btn btn-red",
            removeLabel: "",
            removeIcon: '<i class="glyphicon glyphicon-trash"></i>',
            maxFileSize: 1024
        });
    </script>
@endsection
