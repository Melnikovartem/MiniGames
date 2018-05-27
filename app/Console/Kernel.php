<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Redis;
use App\Session;
use App\Game;
use App\User;

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
          $game = Game::findOrFail($session->game_id);
          if($session->users()->count() == $game->start_users){
            $data = [];
            foreach($session->users()->get() as $session_user){
              $user = User::find($session_user->user_id);
              array_push($data, ['name'=>$user->name, 'code'=>$session_user->code]);
            }
            Redis::publish($game->name . ':new_game', json_encode(['users' => $data, 'session' => $session->id]));
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
