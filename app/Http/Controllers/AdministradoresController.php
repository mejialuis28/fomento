<?php namespace App\Http\Controllers;

use App\Administrador;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdministradoresController extends Controller {

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
	 * Retorna una pantalla con el listado de administradores activos.
	 *
	 * @return Response
	 */
	public function index()
	{
        $administradores = Administrador::where('activo', '=', true)->paginate(10);
        return view('admin.administradores', compact('administradores'));
	}

    /**
     * Busca un usuario a partir de su documento.
     *
     * @return \Illuminate\View\View
     */
    public function buscar(){
        $documento = Input::get('documento');
        $usuario = User::where('documento', '=', $documento)->first();
        return view('admin.buscar_nuevo_admin', compact('usuario'));
    }

	/**
	 * Agrega un usuario como administrador del sistema.
	 *
	 * @return Response
	 */
	public function store()
	{
        $id = Input::get('id');
        $usuario = User::findOrFail($id);
        $admin = Administrador::where('usuario', '=', $id)->first();
        if($admin)
        {
            $admin->update(array('activo' => true));
        }
        else
        {
            Administrador::create(array('usuario' => $id, 'activo' => true));
        }

        return redirect('admin/administradores')
            ->with(array('mensaje' => 'Se ha agregado correctamente como administrador del sistema el usuario: '.$usuario->nombres, 'tipo' => 'success'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $admin = Administrador::where('usuario', '=', $id)->first();
        $admin->update(array('activo' => false));

        return redirect('admin/administradores')
            ->with(array('mensaje' => 'Se ha eliminado correctamente el usuario de la lista de administradores: '.$admin->user->nombres, 'tipo' => 'success'));
	}

}
