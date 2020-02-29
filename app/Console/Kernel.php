<?php

namespace App\Console;

use App\Reply;
use App\Trip;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\Sitemap\SitemapGenerator;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $trips = Trip::all();
            foreach ($trips as $trip) {
                $date = Carbon::parse($trip->date_time);
                if ($date < Carbon::now()) {
                    $replies = Reply::where('post_id', $trip->id)->get();
                    $trip->users()->detach();
                    foreach ($replies as $reply) {
                        $reply->delete();
                    }
                    $trip->delete();
                }
            }
        })->hourly();

        $schedule->command('backup:run')->daily();

        $schedule->call(function () {
            SitemapGenerator::create(config('app.url'))
                ->writeToFile(public_path('sitemap.xml'));
        })->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
