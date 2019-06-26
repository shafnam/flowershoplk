<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    //Table Name
    protected $table = 'cart_items';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamps
    public $timeStamps = true;

    public function cart()
    {
        return $this->belongsTo('App\Cart');
    }
 
    // public function plans()
    // {
    //     return $this->belongsTo('App\Plan','item_id');
    // }
}
