<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public function roles()
    {
        return $this->belongsToMany('App\Role','role_users','user_id','role_id');
    }

    public function activations(){
        return $this->hasOne('App\activations','user_id','id');
    }

    public function posts(){
        return $this->hasMany('App\posts','user_id','id');
    }

    public function record(){
        return $this->hasMany('App\record','user_id','id');
    }

    public function posts_read(){
        return $this->hasMany('App\posts_read','user_id','id');
    }

    public function categories_auth(){
        return $this->hasMany('App\categories_auth','categories_id','id');
    }
}
