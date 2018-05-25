<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;

class GamesController extends Controller
{
    public function index() {
      return view('main');
    }

    public function games($id) {
      $games = Game::all();
      if ($id == 0)
        $game = 0;
      else
        $game = Game::findOrFail($id);
      return view('details', ['games' => $games, 'gamen' => $game]);
    }

    public function game($id) {
      if ($id == 0)
        return view('default');
      $game = Game::findOrFail($id);
      return view('details', ['game' => $game]);
    }
}
