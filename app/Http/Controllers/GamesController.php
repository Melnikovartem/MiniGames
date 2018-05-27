<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Game;
use App\User;

class GamesController extends Controller
{
    public function index() {
      return view('main');
    }

    public function user() {
      if (!Auth::check()) {
        return redirect('/login');
      }
      $likes = User::likes();
      $user = User::findOrFail(Auth::User()->id);
      $results = User::results();

      $i = 0;
      $res = array();
      foreach ($results as $result) {
        // if ($i > 5)
        //   break;
        $res[$i]['name'] = Game::findOrFail($result->game_id)->name;
        if ($result->status == 1)
          $res[$i]['st'] = 'Победа';
        else if ($result->status == 0)
          $res[$i]['st'] = 'Ничья';
        else
          $res[$i]['st'] = 'Поражение';
        $i++;
      }

      return view('user', ['user' => $user, 'likes' => $likes, 'results' => $res]);
    }



    public function games($id) {
      if (!Auth::check()) {
        return redirect('/login');
      }
      $games = Game::all();
      if ($id == 0) {
        $game = 0;
        $likes = 0;
        $top = 0;
      } else {
        $game = Game::findOrFail($id);
        $likes = Game::likes($id);
        $top = Game::top($id);
      }
      return view('details', ['games' => $games, 'gamen' => $game, 'likes' => $likes, 'top' => $top]);
    }
}
