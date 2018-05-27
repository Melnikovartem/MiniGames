<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Redis;
use App\Session;
use App\Game;

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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
      $schedule->call(function () {
        $sessions = Session::where('status', 1)->get();
        //check users
        foreach($sessions as $session){
          \Log::debug($session);
          $game = Game::findOrFail($session->game_id);
          \Log::debug($session->users()->get());
          \Log::debug($game->start_users);
          if($session->users()->count() == $game->start_users){
            Redis::publish($game->name . ':new_game', json_encode($session->users()));
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
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
