<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Console\Scheduling\Schedule;
use App\Session;
use App\Session_User;
use App\Game;
use Auth;

class PlayGame extends Controller
{
    public function game($game_id){
      //make new session or add to old on
      if(Auth::check()){
        $session = Session::where('status', 1)->where('game_id', $game_id)
          ->firstOrNew(['game_id' => $game_id]);
        $game = Game::findOrFail($session->game_id);
        if($session->users()->count() >= $game->start_users)
          return redirect('/');
        $session->save();
        $session_user = new Session_User();
        $session_user->user_id = Auth::User()->id;
        $session_user->session_id = $session->id;
        $session_user->code = str_random(10);
        $session_user->save();
        return redirect('/ready/' . (string)$session->id);
      }
      else
        return view('no_user');
    }

    public function wait($ses){

      if(Auth::check()){
        $session = Session::findOrFail($ses);
        $game = Game::findOrFail($session->game_id);
        $session_user = Session_User::where('user_id', Auth::User()->id)->firstOrFail();
        return view($game->domain, ['session' => $session->id, 'code' => $session_user->code]);
      }
      else
        return view('no_user');
    }
}
