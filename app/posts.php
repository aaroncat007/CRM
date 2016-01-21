<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class posts extends Model
{
    use SoftDeletes;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['categories_id', 'user_id', 'subject','content'];


        /**
     * 需要被轉換成日期的屬性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function User(){
    	return $this->belongsTo('App\User');
    }

    public function categories(){
    	return $this->belongsTo('App\categories');
    }

    public function posts_reply(){
    	return $this->hasMany('App\posts_reply','posts_id','id');
    }
}
