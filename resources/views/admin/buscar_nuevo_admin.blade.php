<table class="table table-condensed table-bordered">
    <thead>
    <tr class="success">
        <th>Documento</th>
        <th>Nombre</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
        @if($usuario)
             <tr>
               <td>{{ $usuario->documento }}</td>
                <td>{{ $usuario->nombres}} {{ $usuario->apellidos}}</td>
                <td class="text-center">
                    {!! Form::open(['method' => 'POST', 'url' => '/admin/administradores/create', 'id' => 'frmNuevo']) !!}
                    @if($usuario->admin)
                        @if($usuario->admin->activo)
                            <span class="text-danger">Este usuario es Administrador</span>
                        @else
                            <input type="hidden" name="id" value="{{$usuario->id}}"/>
                            <button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-check"></i></button>
                        @endif
                    @else
                        <input type="hidden" name="id" value="{{$usuario->id}}"/>
                        <button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-check"></i></button>
                    @endif
                    {!! Form::close()!!}
                </td>
            </tr>
        @else
            <tr>
                <td colspan="3">No existen ningún usuario con el número de documento ingresado.</td>
            </tr>
        @endif
    </tbody>
</table>
