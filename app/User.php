<?php

namespace App;
use Illuminate\Support\Facades\Cache;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Symfony\Component\HttpKernel\Profiler\Profile;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
    protected $fillable = [
        'name', 'email', 'password','role_id','photo_id', 'is_active',
    ];
    protected $dates = ['last_login_at'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->belongsTo('App\Role');
    }

    public function photo(){
        return $this->belongsTo('App\Photo');
    }
    public function isAdmin(){
        if ($this->role->name == 'administrator' && $this->is_active == 1){
            return true;
        }
        return false;
    
    }
    public function borrows()
    {
        return $this->belongsToMany('App\Borrow');
    }

    
    public function equipment(){
        return $this->hasMany('App\Equipment');
    }

    public function nonconsumable()
    {
        return $this->hasMany('App\NonConsumable');
    }
    
    
}
