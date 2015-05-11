<div class="panel panel-default">
    <div class="panel-heading">Items del préstamo</div>
    <div class="panel-body">
        <table class="table table-condensed table-bordered">
            <thead>
            <tr class="success">
                <th>Placa</th>
                <th>Descripción</th>
                <th>Categoria</th>
                <th>Estado Entrega</th>
                @if($prestamo->estado == 'Devuelto')
                    <th>Estado Devolución</th>
                @endif
            </tr>
            </thead>
            <tbody>

            @if($prestamo->estado == 'Devuelto')
                @foreach($detallesPrestamo as $detalle)
                    <tr>
                        <td>{{ $detalle->item->placa }}</td>
                        <td>{{ $detalle->item->descripcion}}</td>
                        <td>{{ $detalle->item->cat->nombre}}</td>
                        <td>{{ $detalle->estadoIni->nombre}}</td>
                        <td>{{ $detalle->estadoFin->nombre}}</td>
                    </tr>
                @endforeach
            @else
                @foreach($detallesPrestamo as $detalle)
                    <tr>
                        <td>{{ $detalle->item->placa }}</td>
                        <td>{{ $detalle->item->descripcion}}</td>
                        <td>{{ $detalle->item->cat->nombre}}</td>
                        <td>{{ $detalle->estadoIni->nombre}}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Comentarios entrega</div>
    <div class="panel-body">
        {{ $prestamo->observacionesEntrega }}
    </div>
</div>
@if($prestamo->observacionesDevolucion)
<div class="panel panel-default">
    <div class="panel-heading">Comentarios Devolución</div>
    <div class="panel-body">
        {{ $prestamo->observacionesDevolucion }}
    </div>
</div>
@endif