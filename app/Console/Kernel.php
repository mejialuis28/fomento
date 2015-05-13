<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
        'App\Console\Commands\DevolucionRetrasada',
        'App\Console\Commands\DevolucionesRetrasadasDiario',
        'App\Console\Commands\ReservasDia',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('inspire')->hourly();
        $schedule->command('DevolucionRetrasada')->everyFiveMinutes();
        $schedule->command('DevolucionesRetrasadasDiario')->dailyAt('06:00');
        $schedule->command('ReservasDia')->dailyAt('06:05');

	}

}
