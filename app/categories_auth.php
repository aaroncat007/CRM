<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class categories_auth extends Model
{
	// use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories_auth';

    //大量賦值 (create)
    protected $fillable = ['categories_id','user_id','permissions'];

    /**
     * 需要被轉換成日期的屬性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function User(){
    	return $this->belongTo('App\User');
    }

    public function categories(){
        return $this->belongsTo(categories::class);
    }
}
