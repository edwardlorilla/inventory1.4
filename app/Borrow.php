<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $fillable = [
        'borrowedby_id', 'user_id', 'nonconsumable_id'
    ];

    public function equipments()
    {
        return $this->belongsToMany('App\Equipment');
    }
    

    public function nonconsumables()
    {
        return $this->belongsToMany('App\NonConsumable');
    }
    public function names()
    {
        return $this->belongsToMany('App\User');
    }
    

    protected function user()
    {
        return $this->belongsTo('App\User');
    }
    protected function borrowedby()
    {
        return $this->belongsTo('App\User');
    }
    protected function users()
    {
        return $this->hasMany('App\User');
    }
    public function nonconsumable()
    {
        return $this->belongsTo('App\NonConsumable');
    }
}
