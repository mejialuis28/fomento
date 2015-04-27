<?php namespace App\Http\Controllers;

use App\DetalleReserva;
use App\EstadoReserva;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Categoria;
use App\Reserva;
use Illuminate\Support\Facades\Input;
use App\Inventario;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Facades\Auth;

class ReservasController extends Controller {

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
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$categorias = Categoria::where('activo', '=', true)->get();
		return view('reservas.create', compact('categorias'));
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function misreservas()
    {
        $reservas = Reserva::Creadas()->get();
        return view('reservas.misreservas', compact('reservas'));
    }

    public function buscaritems()
    {
        $desc = Input::get('desc');
        $categoria = Input::get('cat');
        $inventario = Inventario::Activo()->Descrip($desc)->Cat($categoria)->HabilitadosPrestamo()->get();
        return view('reservas.buscar_items', compact('inventario'));
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $comentarios = Input::get('comentarios');
        $fecha = Input::get('fecha');
        $horaIni = Input::get('horaIni');
        $horaFin = Input::get('horaFin');
        $fechaInicio = $this->formatearFecha($fecha, $horaIni);
        $fechaFin = $this->formatearFecha($fecha, $horaFin);
		$items = json_decode(Input::get('items'));

        //DB::transaction(function($fechaInicio, $fechaFin, $comentarios, $items)
        //    use($fechaInicio, $fechaFin, $comentarios, $items)
        //{
            $nuevaReserva = Reserva::create(array('responsable' => Auth::user()->id,
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin,
                'comentarios' => $comentarios,
                'estado' => EstadoReserva::CREADA));

            foreach ($items as $item) {
                DetalleReserva::create(array('idReserva' => $nuevaReserva->id,
                    'idInventario' => $item->id));
            }
        //});

        return redirect('reservas/misreservas')
            ->with(array('mensaje' => 'Se ha registrado correctamente la reserva', 'tipo' => 'success'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
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
