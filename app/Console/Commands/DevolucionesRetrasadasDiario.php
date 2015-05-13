<?php namespace App\Console\Commands;

use App\Administrador;
use App\EstadoPrestamo;
use App\Prestamo;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Mail;

class DevolucionesRetrasadasDiario extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'DevolucionesRetrasadasDiario';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Envia un mail diario a los administradores notificandoles cuales préstamos no han sido retornados';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
        $prestamosSinDevolver = Prestamo::where('fechaFin','<',Carbon::now())
            ->where('estado', '=', EstadoPrestamo::PRESTADO)->get();

        $admins = Administrador::where('activo', '=', true)->get();
        $destinatarios = array();
        foreach($admins as $admin)
        {
            $destinatarios[] = $admin->user->email;
        }

        if($prestamosSinDevolver->count())
        {
            $data = array('prestamos' => $prestamosSinDevolver);
            Mail::send('mail.prestamosretrasados', $data, function($message) use ($prestamosSinDevolver, $destinatarios)
            {
                $message->to($destinatarios)->subject('Fomento Cultural PJIC - Prestamos sin devolver '.Carbon::now()->format('d/m/Y'));
            });
        }
        $this->comment('Se han enviado correctamente el mail de prestamos sin devolución.');
	}

}
