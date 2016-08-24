<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $fillable = [
        'name', 'description', 'user_id'
    ];

    public function equipments()
    {
        return $this->belongsToMany('App\Equipment');
    }

    protected function user()
    {
        return $this->belongsTo('App\User');
    }

    protected function users()
    {
        return $this->hasMany('App\User');
    }
}
