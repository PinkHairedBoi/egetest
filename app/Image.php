<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function test()
    {
    	return $this->belongsTo('App\Question');
    }

    protected $fillable = ['id', 'src', 'question_id'];
}
