<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
