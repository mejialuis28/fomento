@extends('master')

@section('content')
    <div class="panel panel-default">

        <div class="panel-heading">
            <h4 class="panel-title">Listado de Estados Artículo</h4>
        </div>

        <div class="panel-body">

            <div class="form-group">
                <button class="btn btn-primary" onclick="abrirModalNuevo()" ><i class="glyphicon glyphicon-plus"></i> Nuevo Estado</button>
            </div>

            <table class="table table-condensed table-bordered">
                <thead>
                <tr class="success">
                    <th>Nombre Estado</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($estados as $est)
                    <tr>
                        <td>{{ $est->nombre }}</td>
                        <td class="text-center">
                            <button onclick="abrirModalEditar(this)" class="btn btn-grey btn-sm" data-edit-id="{{$est->id}}" data-edit-nombre="{{$est->nombre}}"><i class="glyphicon glyphicon-pencil"></i></button>
                            <button onclick="eliminarEstado(this)" class="btn btn-red btn-sm" data-delete-id="{{$est->id}}"><i class="glyphicon glyphicon-remove"></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="form-group">
                <button class="btn btn-primary" onclick="abrirModalNuevo()"><i class="glyphicon glyphicon-plus"></i> Nuevo Estado</button>
            </div>
            <div class="text-center">
                <?php echo $estados->appends(Request::except('page'))->render(); ?>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="mdlEditar" tabindex="-1" role="dialog" aria-hidden="true">
        <div id="dialogo" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title">Editar Estado Artículo</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['method' => 'PUT', 'id' => 'frmEditar']) !!}
                    <label for="txtEditNombre" class="control-label">Nombre del estado</label>
                    <input id="txtEditNombre" type="text" name="nombre" class="form-control" required/>
                    {!! Form::close()!!}
                </div>
                <div class="modal-footer">
                    <button onclick="enviarForm('frmEditar')" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Guardar</button>
                    <button class="btn btn-red" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mdlNuevo" tabindex="-1" role="dialog" aria-labelledby="mdlTitulo" aria-hidden="true">
        <div id="dialogo" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="mdlTitulo">Nuevo Estado Artículo</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['method' => 'POST', 'url' => '/admin/estados/create', 'id' => 'frmNuevo']) !!}
                    <label for="txtNombre" class="control-label">Nombre del estado</label>
                    <input id="txtNombre" type="text" name="nombre" class="form-control" required/>
                    {!! Form::close()!!}
                </div>
                <div class="modal-footer">
                    <button onclick="enviarForm('frmNuevo')" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Guardar</button>
                    <button class="btn btn-red" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">

        $( document ).ready(function() {
            $('#mdlNuevo').on('hidden.bs.modal', function () {
                $("#txtNombre").val("");
            });
        });

        function enviarForm(id) {
            $('#' + id).submit();
        }

        function abrirModalNuevo() {
            $('#mdlNuevo').appendTo("body").modal('show');
        }

        function abrirModalEditar(element){
            var editId = element.getAttribute('data-edit-id');
            var editNombre = element.getAttribute('data-edit-nombre');
            $('#frmEditar').attr('action', '{{url('admin/estados/edit')}}' + '/' + editId)
            $('#txtEditNombre').val(editNombre);
            $('#mdlEditar').appendTo("body").modal('show');
        }

        function eliminarEstado(element){
            var deleteId = element.getAttribute('data-delete-id');
            if(confirm('¿Está seguro de eliminar el estado?'))
            {
                var form =
                        $('<form>', {
                            'method': 'POST',
                            'action': "{{url('admin/estados/delete')}}" + '/' + deleteId
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