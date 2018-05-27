<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'sessions';
    protected $fillable = [
        'game_id'
    ];
    public function users()
    {
        return $this->hasMany('App\Session_User', 'session_id', 'id');
    }
}
