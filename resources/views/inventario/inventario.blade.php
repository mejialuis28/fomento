@extends('master')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Filtros</h4>
        </div>
        <div class="panel-body">
            {!! Form::open(['method' => 'GET']) !!}
                <fieldset>
                    <div class="form-group">

                        <label for="txtCat" class="col-md-1 control-label">Categoría</label>
                        <div class="col-md-2">
                            <select class="form-control"  name="cat" id="txtCat" onchange="this.form.submit()">
                                <option value="0">-Todas-</option>
                                @foreach($categorias as $cat)
                                    @if($cat->id == $input['cat'] )
                                        <option value="{{ $cat->id }}" selected>{{ $cat->nombre }}</option>
                                    @else
                                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <label for="txtPlaca" class="col-md-1 control-label">Placa</label>
                        <div class="col-md-2">
                            <input id="txtPlaca" class="form-control" value="{{ $input['placa'] }}" name="placa" type="text" placeholder=" Número de placa"/>
                        </div>

                        <label for="txtDescripcion" class="col-md-1 control-label">Descripción</label>
                        <div class="col-md-2">
                            <input id="txtDescripcion" class="form-control" value="{{ $input['desc'] }}" name="desc" type="text" placeholder=" Descripción"/>
                        </div>

                        <div class="col-md-1">
                            <button class="btn btn-default"><i class="glyphicon glyphicon-search"></i> Filtrar</button>
                        </div>
                        <div class="col-md-1">
                            <a href="{{url('inventario')}}" class="btn btn-red"><i class="glyphicon glyphicon-remove"></i> Limpiar</a>
                        </div>
                    </div>
                </fieldset>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="panel panel-default">

        <div class="panel-heading">
            <h4 class="panel-title">Items de Inventario</h4>
        </div>

        <div class="panel-body">

            <div class="form-group">
                <a class="btn btn-primary" href="inventario/create"><i class="glyphicon glyphicon-plus"></i> Nuevo Item</a>
            </div>

            <table class="table table-condensed table-bordered">
                <thead>
                <tr class="success">
                    <th>Placa</th>
                    <th>Descripción</th>
                    <th>Categoria</th>
                    <th>Valor</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($inventario as $item)
                    <tr>
                        <td>{{ $item->placa }}</td>
                        <td>{{ $item->descripcion }}</td>
                        <td>{{ $item->cat->nombre }}</td>
                        <td>{{ $item->valor }}</td>
                        <td class="text-center">
                            <a href="javascript: verDetalle('{{url('inventario/details')}}/{{ $item->id }}');" class="btn btn-grey btn-sm"><i class="glyphicon glyphicon-list"></i></a>
                            <a href="inventario/edit/{{$item->id}}" class="btn btn-grey btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>
                            <button onclick="eliminarInventario(this)" class="btn btn-red btn-sm" data-delete-id="{{$item->id}}"><i class="glyphicon glyphicon-remove"></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="form-group">
                <a class="btn btn-primary" href="inventario/create"><i class="glyphicon glyphicon-plus"></i> Nuevo Item</a>
            </div>
            <div class="text-center">
                <?php echo $inventario->appends(Request::except('page'))->render(); ?>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="mdlDetalle" tabindex="-1" role="dialog" aria-labelledby="mdlTitulo" aria-hidden="true">
        <div id="dialogo" class="modal-dialog">

        </div>
    </div>

    <div class="modal fade" id="mdlImagen" tabindex="-2" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    <img id="imgAmpliada" class="img-responsive">
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $('#mdlDetalle').on('hidden.bs.modal', function () {
                $('#dialogo').html('');
            });
        });
        function verDetalle(url) {
            $.ajax({
                url: url,
                error: function () {
                    $('#dialogo').html("<div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
                    "</div><div class='modal-body'><p class='bg-danger'>Se presentó un error al consultar la información. Cierre la ventana e intente nuevamente.</p></div></div>");
                },
                success: function (data) {
                    $('#dialogo').html(data);
                }
            });
            $('#mdlDetalle').appendTo("body").modal('show');
        }
        function verImagen(src) {
            $('#imgAmpliada').attr('src', src);
            $('#mdlImagen').appendTo("body").modal('show');
        }

        function eliminarInventario(element){
            var deleteId = element.getAttribute('data-delete-id');
            if(confirm('¿Está seguro de eliminar el registro?'))
            {
                var form =
                        $('<form>', {
                            'method': 'POST',
                            'action': "{{url('inventario/delete')}}" + '/' + deleteId
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
