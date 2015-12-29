<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class posts_read extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts_read';

    public function posts_reply(){
    	return $this->belongsTo('App\posts_reply');
    }

    public function User(){
    	return $this->belongTo('App\User');
    }
}
