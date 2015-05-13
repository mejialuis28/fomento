@extends('master')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Filtros</h4>
        </div>
        <div class="panel-body">
            {!! Form::open(['method' => 'GET']) !!}
                <fieldset>
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
                    <div class="form-group">
                        <label for="txtResp" class="col-md-2 control-label">Responsable</label>
                        <div class="col-md-4">
                            <select class="form-control"  name="resp" id="txtResp">
                                <option value="0">-Todos-</option>
                                @foreach($responsable as $resp)
                                    @if($resp->id == $input['est'] )
                                        <option value="{{ $est->id }}" selected>{{ $est->nombre }}</option>
                                    @else
                                        <option value="{{ $est->id }}">{{ $est->nombre }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </fieldset>
            {!! Form::close() !!}
        </div>
    </div>

    @if($inventario->count())
    <div class="panel panel-default">

        <div class="panel-heading">
            <h4 class="panel-title">Items de Inventario</h4>
        </div>

        <div class="panel-body">

            <div class="form-group">
                <a class="btn btn-primary" href="inventario/create">Exportar</a>
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
                    <th>FechaIngreso</th>
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
    <script type="text/javascript">

    </script>
@endsection
