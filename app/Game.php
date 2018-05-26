<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

    public function comments() {
      return $this->hasMany('App\Comment', 'game_id', 'id');
    }

    public static function likes($gid) {
      $likes = Like::where('game_id', '=', $gid)->get();
      return count($likes);
    }

    public static function top($gid) {
      $users = User::all();
      $res = array();
      foreach ($users as $user) {
        $res[$user->name] = count(Result::where('user_id', '=', $user->id)->where('game_id', '=', $gid)->where('status', '=', 1)->get());
      }
      arsort($res);
      $i = 0;
      $users = array();
      foreach ($res as $key => $user) {
        if ($i > 5 || $user == 0)
          break;
        $users[$i] = array('user' => $key, 'result' => $user);
        $i++;
      }
      return $users;
    }

    protected $table = 'games';
}
