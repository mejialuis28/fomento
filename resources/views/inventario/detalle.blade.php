<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="mdlTitulo">Detalle del artículo <strong>{{$inventario->placa}}</strong></h5>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-3 col-lg-3 " align="center">
                <img onclick="verImagen(this.src)" alt="Foto artículo" src="{{url($inventario->rutaImagen)}}" class="img-responsive"/>
                </br>
            </div>
            <div class=" col-md-9 col-lg-9 ">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Placa:</td>
                            <td>{{$inventario->placa}}</td>
                        </tr>
                        <tr>
                            <td>Descripción:</td>
                            <td>{{$inventario->descripcion}}</td>
                        </tr>
                        <tr>
                            <td>Categoria;</td>
                            <td>{{$inventario->cat->nombre}}</td>
                        </tr>
                        <tr>
                        <tr>
                            <td>Valor:</td>
                            <td>{{$inventario->valor}}</td>
                        </tr>
                        <tr>
                            <td>Marca:</td>
                            <td>{{$inventario->marca}}</td>
                        </tr>
                        <tr>
                            <td>Estado:</td>
                            <td>{{$inventario->est->nombre}}</td>
                        </tr>
                            <td>Responsable:</td>
                            <td>{{$inventario->user->nombres}}</td>
                        </tr>
                        </tr>
                            <td>Habilitado Préstamo</td>
                            <td>
                                @if($inventario->habilitadoPrestamo)
                                    Si
                                @else
                                    No
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-red" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cerrar</button>
        <a class="btn btn-grey" href="inventario/edit/{{$inventario->id}}"><i class="glyphicon glyphicon-pencil"/> Editar</a>
    </div>
</div>