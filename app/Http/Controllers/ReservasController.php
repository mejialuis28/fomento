<?php namespace App\Http\Controllers;

use App\DetalleReserva;
use App\EstadoReserva;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Categoria;
use App\Reserva;
use App\Prestamo;
use Illuminate\Support\Facades\Input;
use App\Inventario;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
		$reservas = Reserva::oldest('fechaInicio')->Creadas()->paginate(10);
        $historial = Reserva::latest('updated_at')->where('estado', '!=', EstadoReserva::CREADA)->paginate(10)->setPageName("pageh");

        return view('reservas.reservas', compact('reservas', 'historial'));
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
        $reservas = Reserva::where('responsable', '=', Auth::user()->id)->SinEjecutar()->latest('created_at')->paginate(10);
        $prestamos = Prestamo::where('responsable', '=', Auth::user()->id)->latest('created_at')->paginate(10)->setPageName('pageh');
        return view('reservas.misreservas', compact('reservas', 'prestamos'));
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
     * Muestra el detalle de una reserva.
     *
     * @param  int  $id
     * @return Response
     */
    public function details($id)
    {
        $reserva = Reserva::find($id);
        $detallesReserva = DetalleReserva::where('idReserva', '=', $id)->get();
        $items = array();
        foreach ($detallesReserva as $detalle) {
            $items[] = $detalle->item;
        }
        return view('reservas.detalle_reserva', compact('reserva', 'items'));
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$reserva = Reserva::findOrFail($id);
        $reserva->update(array('estado' => EstadoReserva::CANCELADA));
        return redirect('reservas/misreservas')->with(array('mensaje' => 'Se ha cancelado correctamente la reserva.', 'tipo' => 'success'));;
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function rechazar()
    {
        $id = Input::get('idReserva');
        $motivo = Input::get('motivo');
        $reserva = Reserva::findOrFail($id);
        $reserva->update(array('estado' => EstadoReserva::RECHAZADA, 'motivoRechazo' => $motivo));

        $data = array('nombre' => $reserva->user->nombres, 'numero' => $reserva->id, 'motivo' => $reserva->motivoRechazo);

        Mail::queue('mail.rechazo', $data, function($message) use ($reserva)
        {
            $message->to($reserva->user->email, $reserva->user->nombres)->subject('Fomento Cultural PJIC -Rechazo reserva '.$reserva->id);
        });

        return redirect('reservas')->with(array('mensaje' => 'Se ha rechazado correctamente la reserva.', 'tipo' => 'success'));
    }

    private function formatearFecha($fecha, $hora)
    {
        return $fecha.' '.$hora;
    }

}
