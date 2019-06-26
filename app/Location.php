<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //Table Name
    protected $table = 'locations';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamps
    public $timeStamps = true;

    public function shops()
    {
        return $this->belongsToMany('App\Shop','location_shop')->withTimestamps()->withPivot('delivery_charge');
    }
}
