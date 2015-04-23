<table class="table table-condensed table-bordered">
    <thead>
    <tr class="success">
        <th>Placa</th>
        <th>Descripción</th>
        <th>Categoría</th>
        <th>Estado</th>
        <th>Agregar a reserva</th>
    </tr>
    </thead>
    <tbody>
    @if($inventario->count())
        @foreach($inventario as $item)
        <tr>
            <td>{{ $item->placa }}</td>
            <td>{{ $item->descripcion}}</td>
            <td>{{ $item->cat->nombre}}</td>
            <td>{{ $item->est->nombre}}</td>
            <td class="text-center">
                <button class="btn btn-primary btn-sm" onclick="agregarItemReserva({{$item->id}}, this)"><i class="glyphicon glyphicon-check"></i></button>
            </td>
        </tr>
        @endforeach
    @else
        <tr>
            <td colspan="3">No existen items que coincidan con los criterios de búsqueda.</td>
        </tr>
    @endif
    </tbody>
</table>