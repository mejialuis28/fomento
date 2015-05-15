@extends('master')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Filtros - Reporte de Inventario</h4>
        </div>
        <div class="panel-body">
            {!! Form::open(['method' => 'GET', 'class' => 'form-horizontal']) !!}
                <fieldset>
                    <div>
                        <div class="form-group">
                            <label for="txtCat" class="col-md-2 control-label">Categoría</label>
                            <div class="col-md-4">
                                <select class="form-control"  name="cat" id="txtCat">
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

                            <label for="txtEstado" class="col-md-2 control-label">Estado</label>
                            <div class="col-md-4">
                                <select class="form-control"  name="est" id="txtEst">
                                    <option value="0">-Todos-</option>
                                    @foreach($estados as $est)
                                        @if($est->id == $input['est'] )
                                            <option value="{{ $est->id }}" selected>{{ $est->nombre }}</option>
                                        @else
                                            <option value="{{ $est->id }}">{{ $est->nombre }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="txtResp" class="col-md-2 control-label">Responsable</label>
                            <div class="col-md-4">
                                <select class="form-control"  name="resp" id="txtResp">
                                    <option value="0">-Todos-</option>
                                    @foreach($administradores as $admin)
                                        @if($admin->usuario == $input['resp'] )
                                            <option value="{{ $admin->usuario }}" selected>{{ $admin->user->nombres.' '.$admin->user->apellidos }}</option>
                                        @else
                                            <option value="{{ $admin->usuario }}">{{ $admin->user->nombres.' '.$admin->user->apellidos }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-md-offset-2">
                                <button class="btn btn-default">Generar</button>
                            </div>

                        </div>
                    </div>
                </fieldset>
            {!! Form::close() !!}
        </div>
    </div>

    @if(isset($inventario))
    <div class="panel panel-default">

        <div class="panel-heading">
            <h4 class="panel-title">Items de Inventario</h4>
        </div>

        <div class="panel-body">

            <div class="form-group">
                <button class="btn btn-primary" id="exportar">Exportar</button>
            </div>

            <table class="table table-condensed table-bordered">
                <thead>
                <tr class="success">
                    <th>Placa</th>
                    <th>Descripción</th>
                    <th>Categoria</th>
                    <th>Valor</th>
                    <th>Marca</th>
                    <th>Estado</th>
                    <th>Fecha Ingreso</th>
                    <th>Responsable</th>
                    <th>Habilitado Préstamo</th>
                </tr>
                </thead>
                <tbody>
                @foreach($inventario as $item)
                    <tr>
                        <td>{{ $item->placa }}</td>
                        <td>{{ $item->descripcion }}</td>
                        <td>{{ $item->cat->nombre }}</td>
                        <td>{{ $item->valor }}</td>
                        <td>{{ $item->marca }}</td>
                        <td>{{ $item->est->nombre }}</td>
                        <td>{{ $item->fechaIngreso }}</td>
                        <td>{{ $item->user->nombres.' '.$item->user->apellidos }}</td>
                        <td> @if($item->habilitadoPrestamo)
                                Si
                            @else
                                No
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
    @endif

@endsection
@section('scripts')

    <script src="{{asset('js/jquery.table2excel.js')}}" type="text/javascript"></script>

    <script type="text/javascript">

        $('#exportar').on('click', function() {
            $(".table").table2excel({
                name: "Excel Document Name",
                filename: "inventario"
            });
        });
    </script>
@endsection
