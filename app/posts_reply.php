<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class posts_reply extends Model
{
    use SoftDeletes;

      /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts_reply';

    /**
     * 需要被轉換成日期的屬性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    public function User(){
    	return $this->belongTo('App\User');
    }

    public function posts(){
    	return $this->belongTo('App\posts');
    }

    public function posts_read(){
    	return $this->hasMany('App\posts_read','reply_id','id');
    }
}
