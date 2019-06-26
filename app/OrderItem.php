<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //Table Name
    protected $table = 'order_items';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamps
    public $timeStamps = true;

    /* one to one relationship between users and orders */
    public function orders()
    {
        return $this->belongsTo('App\Order','order_id');
    }
}
