<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function likes() {
      $likes = Like::where('user_id', '=', Auth::User()->id)->get();
      return count($likes);
    }

    public static function results() {
      $res = Result::where('user_id', '=', Auth::User()->id)->get();
      return $res;
    }
}
