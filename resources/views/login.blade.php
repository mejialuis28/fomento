@extends('master')

@section('content')
    <form class="form-horizontal" role="form" method="POST" action="login">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <label class="col-md-4 control-label">Identificación</label>
            <div class="col-md-5">
                <input type="text" class="form-control" name="documento" required placeholder="Número de documento"/>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Password</label>
            <div class="col-md-5">
                <input type="password" class="form-control" name="password" placeholder="Ingrese un password" required>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-5 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Ingresar
                </button>
            </div>
        </div>
    </form>
@endsection
