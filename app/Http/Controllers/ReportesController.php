<?php namespace App\Http\Controllers;

use App\Categoria;
use App\Administrador;
use App\DetallePrestamo;
use App\DetalleReserva;
use App\EstadoPrestamo;
use App\Inventario;
use App\EstadoArticulo;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Prestamo;
use App\Reserva;
use Carbon\Carbon;
Use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ReportesController extends Controller {

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
    public function inventario()
    {
        $administradores = Administrador::where('activo', '=', 1)->with('user')->get();
        $categorias = Categoria::where('activo', '=', 1)->get();
        $estados = EstadoArticulo::where('activo', '=', 1)->get();

        $input = Input::all();
        if($input)
        {
            $resp = Input::get('resp');
            $estado = Input::get('est');
            $categoria = Input::get('cat');

            $inventario = Inventario::Activo()->Cat($categoria)->Resp($resp)->Estado($estado)->with('user','cat','est')->get();

            return view('reportes.rptInventario', compact('inventario','categorias', 'estados', 'administradores', 'input'));
        }
        else
        {
            $input['resp'] = '';
            $input['est'] = '';
            $input['cat'] = '';

        }

        return view('reportes.rptInventario', compact('categorias', 'estados', 'administradores','input'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function reservas()
    {
        $input = Input::all();
        if($input)
        {
            $ini = Input::get('ini');
            $fin = Input::get('fin');
            $est = Input::get('est');

            $fechaIni = Carbon::createFromFormat('d/m/Y H:i', $ini.' 00:00');
            $fechaFin = Carbon::createFromFormat('d/m/Y H:i', $fin.' 23:59');

            $detallesReserva = DetalleReserva::whereHas('reserva', function($q) use($fechaIni,$fechaFin, $est){
                $q->whereBetween('fechaInicio', [$fechaIni, $fechaFin]);
                if($est) {
                    $q->where('estado', '=', $est);
                }
            })->with('reserva','item', 'reserva.user')->get();

            return view('reportes.rptReservas', compact('detallesReserva', 'input'));
        }
        else
        {
            $input['ini'] = '';
            $input['fin'] = '';
            $input['est'] = '';
        }

        return view('reportes.rptReservas', compact('input'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function prestamos()
    {
        $input = Input::all();
        if($input)
        {
            $ini = Input::get('ini');
            $fin = Input::get('fin');
            $est = Input::get('est');

            $fechaIni = Carbon::createFromFormat('d/m/Y H:i', $ini.' 00:00');
            $fechaFin = Carbon::createFromFormat('d/m/Y H:i', $fin.' 23:59');

            $detallesPrestamo = DetallePrestamo::whereHas('prestamo', function($q) use($fechaIni,$fechaFin, $est){
                $q->whereBetween('fechaInicio', [$fechaIni, $fechaFin]);
                if($est) {
                    $q->where('estado', '=', $est);
                }
            })->with('prestamo','item', 'prestamo.user')->get();

            return view('reportes.rptPrestamos', compact('detallesPrestamo', 'input'));
        }
        else
        {
            $input['ini'] = '';
            $input['fin'] = '';
            $input['est'] = '';
        }

        return view('reportes.rptPrestamos', compact('input'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function retrasados()
    {
        $input = Input::all();
        if($input)
        {
            $ini = Input::get('ini');
            $fin = Input::get('fin');

            $fechaIni = Carbon::createFromFormat('d/m/Y H:i', $ini.' 00:00');
            $fechaFin = Carbon::createFromFormat('d/m/Y H:i', $fin.' 23:59');

            $detallesPrestamo = DetallePrestamo::whereHas('prestamo', function($q) use($fechaIni,$fechaFin){
                $q->whereBetween('fechaInicio', [$fechaIni, $fechaFin]);
                $q->where('estado', '=', EstadoPrestamo::PRESTADO);
                $q->where('fechaFin', '<', Carbon::now());
            })->with('prestamo','item', 'prestamo.user')->get();

            return view('reportes.rptRetrasados', compact('detallesPrestamo', 'input'));
        }
        else
        {
            $input['ini'] = '';
            $input['fin'] = '';
        }

        return view('reportes.rptRetrasados', compact('input'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function indicadores()
    {
        $input = Input::all();
        if($input)
        {
            $ini = Input::get('ini');
            $fin = Input::get('fin');

            $fechaIni = Carbon::createFromFormat('d/m/Y H:i', $ini.' 00:00');
            $fechaFin = Carbon::createFromFormat('d/m/Y H:i', $fin.' 23:59');

            $reservas = Reserva::whereBetween('fechaInicio', [$fechaIni,$fechaFin])->count();
            $prestamos = Prestamo::whereBetween('fechaInicio', [$fechaIni,$fechaFin])->count();
            $prestamosConReserva = Prestamo::whereBetween('fechaInicio', [$fechaIni,$fechaFin])->whereNotNull('idReserva')->count();
            $prestamosSinReserva = $prestamos - $prestamosConReserva;
            $prestamosSinDevolucion = Prestamo::whereBetween('fechaInicio', [$fechaIni,$fechaFin])->Prestados()->where('fechaFin','<', Carbon::now())->count();

            $totales = array('reservas' => $reservas, 'prestamos' => $prestamos,'prestamosConReserva' => $prestamosConReserva,
                'prestamosSinReserva' => $prestamosSinReserva,'prestamosSinDevolucion' => $prestamosSinDevolucion);

            $prestamosPorUusario = DB::table('prestamos')->join('users', 'users.id', '=', 'prestamos.responsable')
                ->join('tipousuario', 'tipousuario.id', '=', 'users.tipoUsuario')->whereBetween('prestamos.fechaInicio', [$fechaIni,$fechaFin])
                ->select(DB::raw('count(*) as cantidad, tipousuario.nombre as tipo'))
                ->groupBy('tipousuario.nombre')
                ->get();

            $prestamosPorCategoria = DB::table('detalleprestamos')->join('prestamos', 'detalleprestamos.idPrestamo', '=', 'prestamos.id')
                ->join('inventario', 'detalleprestamos.idInventario', '=', 'inventario.id')
                ->join('categorias', 'inventario.categoria', '=', 'categorias.id')
                ->whereBetween('prestamos.fechaInicio', [$fechaIni,$fechaFin])
                ->select(DB::raw('count(*) as cantidad, categorias.nombre as categoria'))
                ->groupBy('categorias.nombre')
                ->get();

            $indicadores = array('totales' => $totales, 'prestamosPorUsuario' => $prestamosPorUusario,
                'prestamosPorCategoria' => $prestamosPorCategoria);

            return view('reportes.rptIndicadores', compact('indicadores','input'));
        }
        else
        {
            $input['ini'] = '';
            $input['fin'] = '';
        }

        return view('reportes.rptIndicadores', compact('input'));
    }

}
