<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = ['item', 'description','status','category_id', 'photo_id', 'nonconsumable_id','consumable','outOfStock','hasQuantity', 'location_id','hasStaticEquipment', 'stockin_id','hasBorrow'];
    public function borrows()
    {
        return $this->belongsToMany('App\Borrow');
    }
    public function reservations()
    {
        return $this->belongsToMany('App\Reservation');
    }
    public function stockins()
    {
        return $this->hasMany('App\Stockin');
    }
    public function stockin()
    {
        return $this->belongsTo('App\Stockin');
    }
    
    
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function photo(){
        return $this->belongsTo('App\Photo');
    }
    public  function  category()
    {
        return $this->belongsTo('App\Category');
    }

    public function nonconsumable()
    {
      return $this->belongsTo('App\NonConsumable');  
    }
}
