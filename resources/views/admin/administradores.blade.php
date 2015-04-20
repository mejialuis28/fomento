@extends('master')

@section('content')
    <div class="panel panel-default">

        <div class="panel-heading">
            <h4 class="panel-title">Listado de Usuarios Administradores</h4>
        </div>

        <div class="panel-body">

            <div class="form-group">
                <button class="btn btn-primary" onclick="abrirModalNuevo()" ><i class="glyphicon glyphicon-plus"></i> Nuevo Admin</button>
            </div>

            <table class="table table-condensed table-bordered">
                <thead>
                <tr class="success">
                    <th>Documento</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($administradores as $admin)
                    <tr>
                        <td>{{ $admin->user->documento }}</td>
                        <td>{{ $admin->user->nombres}} {{ $admin->user->apellidos}}</td>
                        <td class="text-center">
                            @if($admin->user->id != Auth::user()->id)
                                <button onclick="eliminarAdministrador(this)" class="btn btn-red btn-sm" data-delete-id="{{$admin->user->id}}"><i class="glyphicon glyphicon-remove"></i></button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="form-group">
                <button class="btn btn-primary" onclick="abrirModalNuevo()"><i class="glyphicon glyphicon-plus"></i> Nuevo Admin</button>
            </div>
            <div class="text-center">
                <?php echo $administradores->appends(Request::except('page'))->render(); ?>
            </div>

        </div>
    </div>

    <div class="modal fade" id="mdlNuevo" tabindex="-1" role="dialog" aria-labelledby="mdlTitulo" aria-hidden="true">
        <div id="dialogo" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="mdlTitulo">Nuevo Administrador</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        {!! Form::open(['id' => 'frmBuscar']) !!}
                            <label for="txtDocumento" class="control-label col-md-2">Documento</label>
                            <div class="col-md-7">
                                <input id="txtDocumento" type="text" name="documento" placeholder="Ingrese un número de documento" class="form-control" required/>
                            </div>
                            <div class="col-md-3">
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
    <script type="text/javascript">

        $( document ).ready(function() {
            $('#mdlNuevo').on('hidden.bs.modal', function () {
                $("#txtDocumento").val("")
                $("#result").html("");
            });

            $("#frmBuscar").submit(function() {
                $.ajax({
                    url: '{{url('admin/administradores/buscarusuario')}}',
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

        function buscar() {
            $.ajax({
                url: '{{url('admin/administradores/buscarusuario')}}',
                method : 'POST',
                error: function () {
                    $('#result').html("<div><p class='bg-danger'>" +
                    "Se presentó un error al consultar la información. Cierre la ventana e intente nuevamente.</p></div>");
                },
                success: function (data) {
                    $('#result').html(data);
                }
            });
        }

        function abrirModalNuevo() {
            $('#mdlNuevo').appendTo("body").modal('show');
        }

        function eliminarAdministrador(element){
            var deleteId = element.getAttribute('data-delete-id');
            if(confirm('¿Está seguro de retirar el usuario de la lista de administradores?'))
            {
                var form =
                        $('<form>', {
                            'method': 'POST',
                            'action': "{{url('admin/administradores/delete')}}" + '/' + deleteId
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