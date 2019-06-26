<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    //public $fillable = ['product_category_id','name','price','colors','model','brand','dimensions','display','features','description','status'];
    //Table Name
    protected $table = 'shops';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamps
    public $timeStamps = true;

    /* one to many relationship between shops and products */
    public function products()
    {
        return $this->belongsTo('App\Product','product_id');
    }

    public function locations()
    {
        return $this->belongsToMany('App\Location','location_shop')->withTimestamps()->withPivot('delivery_charge');
    }


    // public static function fill_unit_select_box($connect)
    // { 
    //     $output = '';
    //     $query = "SELECT * FROM tbl_unit ORDER BY unit_name ASC";
    //     $statement = $connect->prepare($query);
    //     $statement->execute();
    //     $result = $statement->fetchAll();
    //     foreach($result as $row)
    //     {
    //     $output .= '<option value="'.$row["unit_name"].'">'.$row["unit_name"].'</option>';
    //     }
    //     return $output;
    // }
}
