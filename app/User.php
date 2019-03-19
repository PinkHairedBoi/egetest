<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function test()
    {
        return $this->belongsTo('App\Test');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }
}
