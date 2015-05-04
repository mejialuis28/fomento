<div class="panel panel-default">
    <div class="panel-heading">Comentarios</div>
    <div class="panel-body">
        {{ $comentarios }}
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Items de la reserva</div>
    <div class="panel-body">
        <table class="table table-condensed table-bordered">
            <thead>
            <tr class="success">
                <th>Placa</th>
                <th>Descripción</th>
                <th>Categoria</th>
                <th>Estado</th>
            </tr>
            </thead>
            <tbody>
            @if($items)
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->placa }}</td>
                        <td>{{ $item->descripcion}}</td>
                        <td>{{ $item->cat->nombre}}</td>
                        <td>{{ $item->est->nombre}}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">No existen items con los criterios de búsqueda.</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
