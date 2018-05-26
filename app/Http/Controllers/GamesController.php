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
      $user = User::findOrFail(Auth::User()->id);
      return view('user', ['user' => $user]);
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
