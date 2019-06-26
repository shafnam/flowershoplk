<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    /* one to one relationship between products and product_categpries */
    public function products()
    {
        return $this->hasMany('App\Product','product_category_id');
    }
}
