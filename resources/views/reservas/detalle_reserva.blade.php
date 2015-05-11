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
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->placa }}</td>
                        <td>{{ $item->descripcion}}</td>
                        <td>{{ $item->cat->nombre}}</td>
                        <td>{{ $item->est->nombre}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Comentarios</div>
    <div class="panel-body">
        {{ $reserva->comentarios }}
    </div>
</div>
@if($reserva->motivoRechazo)
<div class="panel panel-danger">
    <div class="panel-heading">Motivo Rechazo</div>
    <div class="panel-body">
        {{ $reserva->motivoRechazo }}
    </div>
</div>
@endif