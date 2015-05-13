<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Prestamo;
use App\EstadoArticulo;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\DetalleReserva;
use App\DetallePrestamo;
use App\Categoria;
use App\EstadoReserva;
use App\EstadoPrestamo;
use App\Administrador;
use App\Reserva;
use Illuminate\Support\Facades\Input;
use App\Inventario;
Use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Facades\Auth;

class PrestamosController extends Controller {

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
        $prestamos = Prestamo::oldest('fechaInicio')->Prestados()->paginate(10);
        $historial = Prestamo::latest('updated_at')->Devueltos()->paginate(10)->setPageName("pageh");
        return view('prestamos.prestamos', compact('prestamos', 'historial'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Input::get('reserva'))
        {
            $administradores = Administrador::where('activo', '=', true)->get();
            $reserva = Reserva::findOrFail(Input::get('reserva'));
            return view('prestamos.create', compact('administradores', 'reserva'));
        }
        else
        {
            abort(404);
        }
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function nuevo()
    {
        $administradores = Administrador::where('activo', '=', true)->get();
        $categorias = Categoria::where('activo', '=', true)->get();
        $fecha = Carbon::now();
        return view('prestamos.nuevo', compact('categorias', 'fecha', 'administradores'));
    }

    /**
     * Busca un usuario a partir de su documento.
     *
     * @return \Illuminate\View\View
     */
    public function buscarResponsable(){
        $documento = Input::get('documento');
        $usuario = User::where('documento', '=', $documento)->first();
        return view('prestamos.buscar_responsable', compact('usuario'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function guardar()
    {
        $obsEntrega = Input::get('observacionesEntrega');
        $responsable = Input::get('responsable');
        $entregadoPor = Input::get('entregadoPor');
        $fecha = Input::get('fecha');
        $horaIni = Input::get('horaIni');
        $horaFin = Input::get('horaFin');
        $fechaInicio = $this->formatearFecha($fecha, $horaIni);
        $fechaFin = $this->formatearFecha($fecha, $horaFin);
        $items = json_decode(Input::get('items'));

        $nuevoPrestamo = Prestamo::create(array('responsable' => $responsable,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'fechaEntrega' => Carbon::now(),
            'entregadoPor' => $entregadoPor,
            'observacionesEntrega' => $obsEntrega,
            'estado' => EstadoPrestamo::PRESTADO));

        foreach ($items as $item) {
            $inventario = Inventario::find($item->id);
            DetallePrestamo::create(array('idPrestamo' => $nuevoPrestamo->id,
                'idInventario' => $item->id,
                'estadoEntrega' => $inventario->estado));
        }

        return redirect('prestamos')
            ->with(array('mensaje' => 'Se ha registrado correctamente el préstamo', 'tipo' => 'success'));
    }

    /**
     * Muestra el detalle de un préstamo.
     *
     * @param  int  $id
     * @return Response
     */
    public function details($id)
    {
        $prestamo = Prestamo::find($id);
        $detallesPrestamo = DetallePrestamo::where('idPrestamo', '=', $id)->get();
        return view('prestamos.detalle_prestamo', compact('prestamo','detallesPrestamo'));
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$reserva = Reserva::findOrFail(Input::get('idReserva'));
        $obsEntrega = Input::get('observacionesEntrega');
        $entregadoPor = Input::get('entregadoPor');
        $fecha = Input::get('fecha');
        $horaIni = Input::get('horaIni');
        $horaFin = Input::get('horaFin');
        $fechaInicio = $this->formatearFecha($fecha, $horaIni);
        $fechaFin = $this->formatearFecha($fecha, $horaFin);
        $nuevoPrestamo = Prestamo::create(array('idReserva' => $reserva->id,
            'responsable' => $reserva->responsable,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'fechaEntrega' => Carbon::now(),
            'entregadoPor' => $entregadoPor,
            'observacionesEntrega' => $obsEntrega,
            'estado' => EstadoPrestamo::PRESTADO));

        foreach ($reserva->items as $detalle) {
            DetallePrestamo::create(array('idPrestamo' => $nuevoPrestamo->id,
                'idInventario' => $detalle->idInventario,
                'estadoEntrega' => $detalle->item->est->id));
        }

        $reserva->update(array('estado' => EstadoReserva::EJECUTADA));

        return redirect('prestamos')->with(array('mensaje' => 'Se ha registrado correctamente el préstamo.', 'tipo' => 'success'));;
	}


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function devolucion()
    {
        if(Input::get('prestamo'))
        {
            $estados = EstadoArticulo::where('activo', '=', 1)->get();
            $administradores = Administrador::where('activo', '=', true)->get();
            $prestamo = Prestamo::findOrFail(Input::get('prestamo'));
            return view('prestamos.devolucion', compact('administradores', 'prestamo', 'estados'));
        }
        else
        {
            abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function devolver()
    {
        $prestamo = Prestamo::findOrFail(Input::get('idPrestamo'));
        $obsDevolucion = Input::get('observacionesDevolucion');
        $recibidoPor = Input::get('recibidoPor');

        foreach ($prestamo->items as $detalle) {
            $estadoDevolucion = Input::get($detalle->idInventario);

            DB::table('detalleprestamos')
                ->where('idPrestamo', $detalle->idPrestamo)
                ->where('idInventario', $detalle->idInventario)
                ->update(array('estadoDevolucion' => $estadoDevolucion));

            if($detalle->item->estado != $estadoDevolucion)
            {
                $detalle->item->update(array('estado' => $estadoDevolucion));
            }
        }

        $prestamo->update(array('fechaDevolucion' => Carbon::now(),
            'recibidoPor' => $recibidoPor,
            'observacionesDevolucion' => $obsDevolucion,
            'estado' => EstadoPrestamo::DEVUELTO));

        return redirect('prestamos')->with(array('mensaje' => 'Se ha registrado correctamente la devolución.', 'tipo' => 'success'));;
    }

    private function formatearFecha($fecha, $hora)
    {
        list($tiempo, $meridiano) = explode(' ', $hora);
        if($meridiano == 'PM')
        {
            list($hh, $mm) = explode(':', $tiempo);
            $hh = $hh + 12;
            $tiempo = $hh.':'.$mm;
        }
        $fechaFormateada = $fecha.' '.$tiempo;
        return $fechaFormateada;
    }

}
