<table class="table table-condensed table-bordered">
    <thead>
    <tr class="success">
        <th>Documento</th>
        <th>Nombre</th>
        <th>Seleccionar</th>
    </tr>
    </thead>
    <tbody>
        @if($usuario)
             <tr>
                <td>{{ $usuario->documento }}</td>
                <td>{{ $usuario->nombres}} {{ $usuario->apellidos}}</td>
                <td class="text-center">
                    <button class="btn btn-primary btn-sm" onclick="agregarResponsable(this)" data-responsable-id="{{ $usuario->id }}"><i class="glyphicon glyphicon-check"></i></button>
                </td>
            </tr>
        @else
            <tr>
                <td colspan="3">No existen ningún usuario con el número de documento ingresado.</td>
            </tr>
        @endif
    </tbody>
</table>
