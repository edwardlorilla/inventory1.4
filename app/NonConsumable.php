<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NonConsumable extends Model
{
    protected $fillable =  ['quantity', 'item' ];
    public function borrows()
    {
        return $this->belongsToMany('App\Borrow');
    }
}
