<?php namespace App\Console\Commands;

use App\Administrador;
use App\EstadoPrestamo;
use App\Prestamo;
use App\Reserva;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Mail;

class ReservasDia extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ReservasDia';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Envia un mail diario a los administradores notificandoles cuales son las reservas del día';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
        $fechaIni = Carbon::createFromFormat('Y-m-d H:i', Carbon::today()->format('Y-m-d').' 00:00');
        $fechaFin = Carbon::createFromFormat('Y-m-d H:i', Carbon::today()->format('Y-m-d').' 23:59');
        $reservas = Reserva::whereBetween('fechaInicio',[$fechaIni, $fechaFin])->get();
        $admins = Administrador::where('activo', '=', true)->get();
        $destinatarios = array();
        foreach($admins as $admin)
        {
            $destinatarios[] = $admin->user->email;
        }

        if($reservas->count())
        {
            $data = array('reservas' => $reservas);
            Mail::send('mail.reservasdia', $data, function($message) use ($destinatarios)
            {
                $message->to($destinatarios)->subject('Fomento Cultural PJIC - Reservas del día '.Carbon::now()->format('d/m/Y'));
            });
        }

        $this->comment('Se han enviado correctamente el mail de reservas del día.');
	}

}
