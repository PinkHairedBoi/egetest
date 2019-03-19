<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function test()
    {
    	return $this->belongsTo('App\Test');
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
    
    protected $fillable = ['question', 'answer', 'test_id'];
    //protected $hidden = ['answer'];

    /*
        0 - Порядок важен (свободный ответ, вариант ответа, цепочка)
        1 - Порядок не важен (варианты ответа)
    */
}
