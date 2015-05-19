<?php namespace App\Http\Controllers;

use App\Administrador;
use App\Categoria;
use App\EstadoArticulo;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Webpatser\Uuid\Uuid;

class InventarioController extends Controller {

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
	 * Muestra la pantalla con el listado de artículos del inventario.
	 *
	 * @return Response
	 */
	public function index()
	{
        $input = Input::except('page');
        $categorias = Categoria::all();
        if($input)
        {
            $placa = Input::get('placa');
            $desc = Input::get('desc');
            $categoria = Input::get('cat');

            $inventario = Inventario::Activo()->Placa($placa)->Descrip($desc)->Cat($categoria)->paginate(10);

            return view('inventario.inventario', compact('inventario','categorias', 'input'));
        }
        else
        {
            $input['placa'] = '';
            $input['desc'] = '';
            $input['cat'] = '';
        }

        $inventario = Inventario::Activo()->paginate(10);
		return view('inventario.inventario', compact('inventario','categorias', 'input'));
	}

	/**
	 * Muestra el formulario de creación de un nevo artículo del inventario.
	 *
	 * @return Response
	 */
	public function create()
	{
        $categorias = Categoria::where('activo', '=', true)->get();
        $estados = EstadoArticulo::where('activo', '=', true)->get();
        $responsables = Administrador::where('activo', '=', true)->get();
        return view('inventario.create', compact('estados','categorias','responsables'));
	}

	/**
	 * Almacena un nuevo artículo al inventario.
	 *
	 * @return Response
	 */
	public function store()
	{
        $directorio = env('FOTO_PATH');
        $input = Input::all();
        $foto = Input::file('foto');

        $ruta = $directorio . 'default_image.png';
        if($foto){
            $extension = $foto->getClientOriginalExtension();
            $filename = Uuid::generate() . ".{$extension}";
            $foto = $foto->move($directorio, $filename);
            $ruta = $directorio . $filename;
        }

        $prestamo = false;
        if(Input::get('habilitadoPrestamo')) {
            $prestamo = true;
        }

        $nuevoItem = Inventario::create(array('placa' => $input['placa'],
            'descripcion' => $input['descripcion'],
            'categoria' => $input['categoria'],
            'valor' => $input['valor'],
            'marca' => $input['marca'],
            'estado' => $input['estadoArticulo'],
            'responsable' => $input['responsable'],
            'fechaIngreso' => $input['fechaIngreso'],
            'habilitadoPrestamo' => $prestamo,
            'activo' => 1,
            'rutaImagen' => $ruta));

        return redirect('inventario')->with(array('mensaje' => 'Se ha agregado correctamente el item: '.$nuevoItem->descripcion, 'tipo' => 'success'));;
	}

	/**
	 * Muestra el detalle de un artículo del inventario.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $inventario = Inventario::where('id', '=', $id)->firstOrFail();
        return view('inventario.detalle', compact('inventario'));
	}

	/**
	 * Carga la pantalla de edición de un artículo del inventario.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $categorias = Categoria::where('activo', '=', true)->get();
        $estados = EstadoArticulo::where('activo', '=', true)->get();
        $responsables = Administrador::where('activo', '=', true)->get();
        $inventario = Inventario::findOrFail($id);
        return view('inventario.editar', compact('inventario', 'categorias','estados','responsables'));
	}

	/**
	 * Actualiza un item del invenetario.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $item = Inventario::findOrFail($id);

        $input = Input::all();
        $prestamo = false;
        if(Input::get('habilitadoPrestamo')) {
            $prestamo = true;
        }

        $item->update(array('placa' => $input['placa'],
            'descripcion' => $input['descripcion'],
            'categoria' => $input['categoria'],
            'valor' => $input['valor'],
            'marca' => $input['marca'],
            'estado' => $input['estadoArticulo'],
            'responsable' => $input['responsable'],
            'fechaIngreso' => $input['fechaIngreso'],
            'habilitadoPrestamo' => $prestamo));

        return redirect('inventario')->with(array('mensaje' => 'Se ha actualizado correctamente el item: '.$item->descripcion, 'tipo' => 'success'));;
    }


    /**
     * Inactiva un item del inventario a partir de su id.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $item = Inventario::findOrFail($id);
        $item->update(array('activo' => 0));
        return redirect('inventario')->with(array('mensaje' => 'Se ha eliminado correctamente el item: '.$item->descripcion, 'tipo' => 'success'));
	}

}
