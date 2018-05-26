<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'sessions';

    public function users()
    {
        return $this->hasMany('App\Session_User', 'id', 'session_id');
    }
}
