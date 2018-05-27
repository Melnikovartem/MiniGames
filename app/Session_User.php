<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session_User extends Model
{
    protected $table = 'sessions_users';

    public function session()
    {
        return $this->hasOne('App\Session', 'id', 'session_id');
    }
}
