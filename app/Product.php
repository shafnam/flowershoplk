<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $fillable = ['product_category_id','name','price','colors','model','brand','dimensions','display','features','description','status'];
    //Table Name
    protected $table = 'products';
    //Primary Key
    public $primaryKey = 'id';
    //TimeStamps
    public $timeStamps = true;

    /* one to one relationship between products and product_categpries */
    public function product_categories()
    {
        return $this->belongsTo('App\ProductCategory','product_category_id');
    }

    /* one to one relationship between products and product_categpries */
    public function shops()
    {
        return $this->belongsTo('App\Shop','shop_id');
    }

    /* one to many relationship between products and product photos */
    public function product_photos()
    {
        return $this->hasMany('App\ProductPhoto','product_id');
    }
}
