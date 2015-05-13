@extends('master')

@section('css')
    <link href="{{ asset('css/timepicker.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Nueva préstamo</h4>
        </div>
        <div class="panel-body">
            <form id="frmGeneral" method="POST" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <fieldset>
                    <div>
                        <div class="form-group">
                            <input id="resp" name="responsable" type="hidden" class="form-control" />
                            <label for="txtResp" class="col-md-2 control-label">Responsable</label>
                            <div class="col-md-4">
                                <div class="input-group bootstrap-timepicker">
                                    <input id="txtResp" name="txtResponsable" type="text" class="form-control" required disabled/>
                                    <span class="input-group-btn"><button class="btn btn-default" onclick="abrirModalResponsable()"><i class="glyphicon glyphicon-plus"></i></button></span>
                                </div>
                            </div>
                            <label for="txtDoc" class="col-md-2 control-label">Documento</label>
                            <div class="col-md-4">
                                <input id="txtDoc" name="documento" class="form-control" type="text" disabled/>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtFecha" class="col-md-2 control-label">Fecha Prestamo</label>
                            <div class="col-md-4">
                                <input id="txtFecha" name="fecha" data-date-format="dd/mm/yyyy" class="form-control" required type="text" value="{{ $fecha->format('d/m/Y') }}" readonly/>
                            </div>
                            <label  class="col-md-2 control-label">Hora inicial y final</label>
                            <div class="col-md-2">
                                <div class="input-group bootstrap-timepicker">
                                    <input id="horaIni" name="horaIni" type="text" class="form-control" required/>
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group bootstrap-timepicker">
                                    <input id="horaFin" name="horaFin" type="text" class="form-control" required/>
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtComentario" class="col-md-2 control-label">Comentarios Entrega</label>
                            <div class="col-md-10">
                                <textarea id="txtComentario" rows="3" name="observacionesEntrega" required class="form-control" placeholder="Observaciones Entrega"></textarea>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
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
                <h5 class="text-center"><strong>Listado de artículos del préstamo</strong></h5>

                <div >
                    <button class="btn btn-default" onclick="abrirModalNuevo();"><i class="glyphicon glyphicon-plus"></i> Nuevo item</button>
                </div>
                </br>
                <table id='tblItems' class="table table-condensed table-bordered">
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
                    <button class="btn btn-default" onclick="abrirModalNuevo();"><i class="glyphicon glyphicon-plus"></i> Nuevo item</button>
                </div>
            </div>
            <hr>
            <div>
                <div class="text-center">
                    <button class="btn btn-default" onclick="$('#frmGeneral').submit()"><i class="glyphicon glyphicon-floppy-disk"></i> Enviar</button>
                    <a href="{{Url('prestamos')}}" class="btn btn-red"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mdlNuevo" tabindex="-1" role="dialog" aria-labelledby="mdlTitulo" aria-hidden="true">
        <div id="dialogo" class="modal-dialog" style="width:70%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="mdlTitulo">Agregar item a préstamo</h5>
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
                            <input id="txtDesc" type="text" name="desc" class="form-control" />
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                        </div>
                        {!! Form::close()!!}
                    </div>
                    <div id="result" style="padding-top: 30px;">

                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-red" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mdlResponsable" tabindex="-1" role="dialog" aria-labelledby="mdlTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="mdlTitle">Seleccionar Responsable</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        {!! Form::open(['id' => 'frmBuscarResponsable']) !!}
                        <label for="txtDocumento" class="control-label col-md-2">Documento</label>
                        <div class="col-md-7">
                            <input id="txtDocumento" type="text" name="documento" placeholder="Ingrese un número de documento" class="form-control" required/>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                        </div>
                        {!! Form::close()!!}
                    </div>
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
    <!-- tomado de http://jdewit.github.io/bootstrap-timepicker -->
    <script src="{{asset('js/timepicker.js')}}" type="text/javascript"></script>

    <script type="text/javascript">

        // Array de items asociados a la reserva.
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

            $('#mdlNuevo').on('hidden.bs.modal', function () {
                $('#result').html('');
            });

            $('#mdlResponsable').on('hidden.bs.modal', function () {
                $('#txtDocumento').val('');
                $('#resultado').html('');
            });

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

            $("#frmBuscarResponsable").submit(function() {
                $.ajax({
                    url: '{{url('prestamos/buscarresponsable')}}',
                    type: 'POST',
                    data: $(this).serialize(),
                    error: function () {
                        $('#resultado').html("<div><p class='bg-danger'>" +
                        "Se presentó un error al consultar la información. Cierre la ventana e intente nuevamente.</p></div>");
                    },
                    success: function (data) {
                        $('#resultado').html(data);
                    }
                });
                return false;
            });

            $("#frmGeneral").submit(function() {
                $('<input />').attr('type', 'hidden')
                        .attr('name', 'items')
                        .attr('value', JSON.stringify(items))
                        .appendTo('#frmGeneral');
                return true;
            });
        });

        function abrirModalNuevo() {
            $('#mdlNuevo').appendTo("body").modal('show');
            return false;
        }

        function abrirModalResponsable() {
            $('#mdlResponsable').appendTo("body").modal('show');
            return false;
        }

        function Item(id, placa, desc, cat, est){
            this.id = id;
            this.placa = placa;
            this.descripcion = desc;
            this.categoria = cat;
            this.estado = est;
        }

        function InsertarItem(nuevoItem)
        {
            //Insertar item
            var tabla = document.getElementById('tblItems').getElementsByTagName('tbody')[0];
            var nuevaFila  = tabla.insertRow(tabla.rows.length);
            var nuevaCelda  = nuevaFila.insertCell(0);
            var texto  = document.createTextNode(nuevoItem.placa);
            nuevaCelda.appendChild(texto);

            nuevaCelda  = nuevaFila.insertCell(1);
            texto  = document.createTextNode(nuevoItem.descripcion);
            nuevaCelda.appendChild(texto);

            nuevaCelda  = nuevaFila.insertCell(2);
            texto  = document.createTextNode(nuevoItem.categoria);
            nuevaCelda.appendChild(texto);

            nuevaCelda  = nuevaFila.insertCell(3);
            texto  = document.createTextNode(nuevoItem.estado);
            nuevaCelda.appendChild(texto);

            nuevaCelda  = nuevaFila.insertCell(4);
            boton = document.createElement('button');
            icono = document.createElement('i');
            icono.className = 'glyphicon glyphicon-remove';
            boton.appendChild(icono);
            boton.setAttribute('onclick', 'eliminarItemReserva(' + nuevoItem.id + ')');
            boton.className = 'btn btn-red btn-sm';
            nuevaCelda.appendChild(boton);
        }

        function agregarItemReserva(itemId, element) {
            var tds = $(element).closest('tr').children();
            var placa = tds[0].innerHTML;
            var desc = tds[1].innerHTML;
            var cat = tds[2].innerHTML;
            var est = tds[3].innerHTML;

            var nuevoItem = new Item(itemId,placa,desc, cat, est);
            items.push(nuevoItem);
            InsertarItem(nuevoItem);

            $('#mdlNuevo').modal('hide');
        }

        function eliminarItemReserva(itemId)
        {
            items = items.filter(function( obj ) {
                return obj.id !== itemId;
            });

            document.getElementById('tblItems').getElementsByTagName('tbody')[0].innerHTML = '';
            for(var i = 0; i < items.length; i++)
            {
                InsertarItem(items[i]);
            }
        }

        function agregarResponsable(elemento)
        {
            var idResponsable = elemento.getAttribute('data-responsable-id');
            var fila = $(elemento).closest('tr');
            $('#resp').val(idResponsable);
            $('#txtResp').val(fila.children()[1].innerHTML);
            $('#txtDoc').val(fila.children()[0].innerHTML);

            $('#mdlResponsable').modal('hide');
        }

    </script>
@endsection