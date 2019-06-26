<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //Table Name
    protected $table = 'orders';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamps
    public $timeStamps = true;

    /* one to one relationship between users and orders */
    // public function users()
    // {
    //     return $this->belongsTo('App\User','user_id');
    // }

    /* one to one relationship between orders and order_items */
    public function order_items()
    {
        return $this->hasMany('App\OrderItem','order_id');
    }
}
