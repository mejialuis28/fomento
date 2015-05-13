<?php namespace App\Console\Commands;

use App\EstadoPrestamo;
use App\Prestamo;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Mail;

class DevolucionRetrasada extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'DevolucionRetrasada';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Envia un mail al usuario notificandole que no ha devuelto los items prestados';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
        $prestamosSinDevolver = Prestamo::where('fechaFin','<',Carbon::now())
            ->where('estado', '=', EstadoPrestamo::PRESTADO)
            ->whereNull('notificadoRetraso')->get();

        $contador = 0;
        foreach($prestamosSinDevolver as $prestamo)
        {
            $contador = $contador +1;
            $data = array('nombre' => $prestamo->user->nombres, 'numero' => $prestamo->id);
            Mail::queue('mail.retrasoentrega', $data, function($message) use ($prestamo)
            {
                $message->to($prestamo->user->email, $prestamo->user->nombres)->subject('Fomento Cultural PJIC - Devolución Préstamo número '.$prestamo->id);
            });

            $prestamo->update(array('notificadoRetraso' => true));
        }
		$this->comment('Se han enviado correctamente '.$contador.' mails por prestamos sin devolución.');
	}

}
