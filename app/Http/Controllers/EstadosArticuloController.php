<?php namespace App\Http\Controllers;

use App\EstadoArticulo;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class EstadosArticuloController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $estados = EstadoArticulo::where('activo', '=', 1)->paginate(10);
        return view('admin.estados', compact('estados'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $nuevaEst = EstadoArticulo::create(array('nombre' => Input::get('nombre'), 'activo' => 1));
        return redirect('admin/estados')->with(array('mensaje' => 'Se ha agregado correctamente el estado: '.$nuevaEst->nombre, 'tipo' => 'success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $estado = EstadoArticulo::findOrFail($id);
        $estado->update(Input::all());

        return redirect('admin/estados')
            ->with(array('mensaje' => 'Se ha actualizado correctamente el estado: '.$estado->nombre, 'tipo' => 'success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $estado = EstadoArticulo::findOrFail($id);
        $estado->update(array('activo' => 0));

        return redirect('admin/estados')
            ->with(array('mensaje' => 'Se ha eliminado correctamente el estado: '.$estado->nombre, 'tipo' => 'success'));
    }

}
