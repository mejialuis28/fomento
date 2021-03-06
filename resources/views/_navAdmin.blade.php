<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        Inventario <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{url('inventario')}}">Administrar Inventario</a></li>
        <li><a href="{{url('inventario/create')}}">Nuevo Artículo</a></li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        Préstamos <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{url('reservas')}}">Administrar Reservas</a></li>
        <li><a href="{{url('prestamos')}}">Administrar Préstamos</a></li>
        <li><a href="{{url('reservas/misreservas')}}">Mis Reservas</a></li>
        <li><a href="{{url('reservas/create')}}">Nueva Reserva</a></li>
        <li><a href="{{url('prestamos/nuevo')}}">Nuevo Préstamo</a></li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        Admin <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{url('admin/administradores')}}">Administradores</a></li>
        <li><a href="{{url('admin/categorias')}}">Categorias</a></li>
        <li><a href="{{url('admin/estados')}}">Estados Artículos</a></li>
    </ul>
</li>
<li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        Reportes <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{url('reportes/inventario')}}">Inventario</a></li>
        <li><a href="{{url('reportes/reservas')}}">Reservas</a></li>
        <li><a href="{{url('reportes/prestamos')}}">Préstamos</a></li>
        <li><a href="{{url('reportes/retrasados')}}">Préstamos no devueltos</a></li>
        <li><a href="{{url('reportes/indicadores')}}">Indicadores</a></li>
    </ul>
</li>
</li>

