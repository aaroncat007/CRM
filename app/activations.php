<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class activations extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activations';

    public function User(){
    	return $this->belongTo('App\User');
    }
}
