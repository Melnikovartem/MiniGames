<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Console\Scheduling\Schedule;
use App\Session;
use App\Session_User;
use App\Game;

class PlayGame extends Controller
{
    public function game($game_id){
      //make new session or add to old one
      if(Auth::User()){
        $session = Session->where('active', 1)->where('game_id',$game_id)->firstOrNew(['gam_id' => $game_id]);
        $game = Game::findOrFail($session->game_id);
        if($session->users()->count() >= $game->users_start)
          return redirect('/');
        $session_user = new Session_User();
        $session_user->user_id = Auth::User()->id;
        $session_user->session_id = $session->id;
        $session_user->code = str_rand(10 only digit)
        return redirect('/ready/' + $session->id);
      }
      else
        return view('no_user');
    }

    public function wait($ses){

      if(Auth::User()){
        $session = Session::findOrFail($ses);
        $game = Game::findOrFail($session->game_id);
        $session_user = Session_User::where('user_id', Auth::User()->id);
        return view($game->domain, ['session' => $session->id, 'code' => $session_user->code]);
      }
      else
        return view('no_user');
    }
}
