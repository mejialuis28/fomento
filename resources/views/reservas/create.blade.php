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
            <form id="frmGeneral" method="POST" class="form-horizontal" action="create">
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
                                <input id="txtFecha" name="fecha" data-date-format="dd/mm/yyyy" value="{{ Input::old('fecha') }}" class="form-control" required type="text" placeholder=" dd/mm/aaaa"/>
                            </div>
                            <label  class="col-md-2 control-label">Hora inicial y final</label>
                            <div class="col-md-2">
                                <div class="input-group bootstrap-timepicker">
                                    <input id="horaIni" name="horaIni" type="text" class="form-control" value="{{ Input::old('horaIni') }}" required/>
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group bootstrap-timepicker">
                                    <input id="horaFin" name="horaFin" type="text" class="form-control" value="{{ Input::old('horaFin') }}" required/>
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtComentario" class="col-md-2 control-label">Comentarios</label>
                            <div class="col-md-10">
                                <textarea id="txtComentario" rows="3" name="comentarios" required class="form-control" placeholder="Comentarios">{{ Input::old('comentarios') }}</textarea>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
            <hr>
            <div>
                <h5 class="text-center"><strong>Listado de artículos de la reserva</strong></h5>

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
                    <a href="{{Url('misreservas')}}" class="btn btn-red"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                </div>
            </div>                
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

@endsection

@section('scripts')
    <!-- tomado de http://www.eyecon.ro/bootstrap-datepicker/ -->
    <script src="{{asset('js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
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
            // Inicializa date picker para la fecha de reserva.
            $('#txtFecha').datepicker();

            $('#mdlNuevo').on('hidden.bs.modal', function () {
                $('#result').html('');
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

             $("#frmGeneral").submit(function() {
                 if($("#txtFecha").val() == "")
                 {
                     alert("Debe seleccionar una fecha de reserva");
                     return false;
                 }
                 var fecha = ObtenerFechaFormateada($("#txtFecha").val());
                 var fechaActual = ObtenerFechaActual();
                 if(fecha < fechaActual)
                 {
                     alert("La fecha de la reserva no puede ser menor a la fecha actual.");
                     return false;
                 }
                 if(!validarHoras()) {
                     alert('La hora final debe ser mayor a la hora inicial');
                     return false;
                 }
                 if(items.length > 0){
                     $('<input />').attr('type', 'hidden')
                             .attr('name', 'items')
                             .attr('value', JSON.stringify(items))
                             .appendTo('#frmGeneral');
                     return true;
                 }
                 else{
                     alert("No se puede enviar una reserva sin items asociados.");
                     return false;
                 }
            });
        });

        function abrirModalNuevo() {
            $('#mdlNuevo').appendTo("body").modal('show');
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

            var filtro = items.filter(function(obj) {
                return (obj.id === itemId);
            });
            if(filtro.length == 0){
                items.push(nuevoItem);
                InsertarItem(nuevoItem);
                $('#mdlNuevo').modal('hide');
            }
            else{
                alert('El item seleccionado ya se encuentra agregado a la reserva');
            }
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

        function ObtenerFechaActual() {
            var date = new Date().setHours(0,0,0,0);
            return date;
        }

        function ObtenerFechaFormateada(fecha) {
            var arrayFecha = fecha.split("/");
            var dia = arrayFecha[0];
            var mes = arrayFecha[1] - 1;
            var ano = arrayFecha[2];
            var date = new Date(ano,mes,dia,0,0,0,0);
            return date;
        }

        function validarHoras() {
            var arrayIni = $("#horaIni").val().split(" ");
            var arrayFin = $("#horaFin").val().split(" ");
            var meridianoIni = arrayIni["1"];
            var meridianoFin = arrayFin["1"];
            if(meridianoFin != meridianoIni)
            {
                if(meridianoIni == 'AM')
                    return true;
                else
                    return false;
            }
            else{
                var horaIni = arrayIni[0].split(":");
                var horaFin = arrayFin[0].split(":");
                if(horaIni[0] == "12")
                {
                    horaIni[0] = "0";
                }
                if(horaFin[0] == "12")
                {
                    horaFin[0] = "0";
                }
                var ini = "" + horaIni[0]+horaIni[1];
                var fin = "" + horaFin[0]+horaFin[1];
                if(fin > ini)
                    return true;
                else
                    return false;
            }
        }

    </script>
@endsection