<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    //Table Name
    protected $table = 'product_photos';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamps
    public $timeStamps = true;
   
    public function products()
    {
        return $this->belongsTo('App\Product','product_id');
    }
}
