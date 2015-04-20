<?php namespace App\Http\Controllers;

use App\Categoria;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CategoriasController extends Controller {


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
        $categorias = Categoria::where('activo', '=', 1)->paginate(10);
        return view('admin.categorias', compact('categorias'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$nuevaCat = Categoria::create(array('nombre' => Input::get('nombre'), 'activo' => 1));
        return redirect('admin/categorias')->with(array('mensaje' => 'Se ha agregado correctamente la categoría: '.$nuevaCat->nombre, 'tipo' => 'success'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $categoria = Categoria::findOrFail($id);
        $categoria->update(Input::all());

        return redirect('admin/categorias')
            ->with(array('mensaje' => 'Se ha actualizado correctamente la categoría: '.$categoria->nombre, 'tipo' => 'success'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$categoria = Categoria::findOrFail($id);
        $categoria->update(array('activo' => 0));

        return redirect('admin/categorias')
            ->with(array('mensaje' => 'Se ha eliminado correctamente la categoría: '.$categoria->nombre, 'tipo' => 'success'));
	}

}
