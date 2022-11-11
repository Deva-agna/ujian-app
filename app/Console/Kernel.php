<?php

namespace App\Console;

use App\Models\Soal;
use App\Models\Ujian;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $ujian_s = Ujian::where('waktu_selesai', '<=', Carbon::now()->toDateTimeString())->where('status', 'active')->get();
            foreach ($ujian_s as $ujian) {
                Ujian::where('id', $ujian->id)->update([
                    'status' => 'completed',
                ]);

                foreach ($ujian->detailUjian as $detailSoal) {
                    Soal::where('id', $detailSoal->soal_id)->where('status_update', true)->update([
                        'status_update' => false,
                    ]);
                }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
