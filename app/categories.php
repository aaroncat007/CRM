<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
	use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

    //大量賦值 (create)
    protected $fillable = ['parent_categories','title','description','deactivate'];


    /**
     * 需要被轉換成日期的屬性。
     *
     * @var array
     */
    protected $dates = ['deleted_at','deactivate'];

    public function post(){
    	return $this->hasMany('App\posts','categories_id','id');
    }

    public function record(){
    	return $this->hasMany('App\record','categories_id','id');
    }

    public function categories_auth(){
        return $this->hasMany('App\categories_auth','categories_id','id');
    }

}
