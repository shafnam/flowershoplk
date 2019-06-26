<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;
    //public $oldCart = null;

    public function __construct($oldCart=null) {
        if($oldCart){
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function add($item, $id, $delivery_fee,$delivery_area) {
        $pid = $id;
        if($this->items) {
            // there are items in the cart            
            if(in_array($pid, array_column($this->items, 'pid'))) {
                // prodcut is already in the cart 
                //if(in_array($delivery_area, $this->items[$pid])) {
                if(in_array($delivery_area, array_column($this->items, 'delivery_area'))) {
                    // delivery area already in array
                    // $item_key = array_search($pid, array_column($this->items, 'pid'));
                    $item_key = null;
                    foreach ($this->items as $key => $val) {
                        if($val['pid'] === $pid && $val['delivery_area'] === $delivery_area) {
                            // same area same product
                            $item_key = $key;
                            $this->items[$item_key]['qty']++;
                            $this->totalQty++;
                            $this->totalPrice += $item->price;
                        }
                    }
                    /*if($item_key != null) {
                        $this->items[$item_key]['qty']++;
                        $this->totalQty++;
                        $this->totalPrice += $item->price;
                    }
                    else {
                        // different area same product
                        $storedItem = ['pid'=> $pid, 'qty'=> 1, 'price'=> $item->price, 'delivery_area'=> $delivery_area, 'delivery_fee'=> $delivery_fee, 'item'=> $item];
                        array_push($this->items, $storedItem);
                        $this->totalQty++;
                        $this->totalPrice += $item->price;
                    }    */               
                } 
                else {
                    // dd($pid); 
                    // different area same product
                    $storedItem = ['pid'=> $pid, 'qty'=> 1, 'price'=> $item->price, 'delivery_area'=> $delivery_area, 'delivery_fee'=> $delivery_fee, 'item'=> $item];
                    array_push($this->items, $storedItem);
                    $this->totalQty++;
                    $this->totalPrice += $item->price;
                }         
            } 
            else {
                //new item
                $storedItem = ['pid'=> $pid, 'qty'=> 1, 'price'=> $item->price, 'delivery_area'=> $delivery_area, 'delivery_fee'=> $delivery_fee, 'item'=> $item];
                array_push($this->items, $storedItem);
                $this->totalQty++;
                $this->totalPrice += $item->price;
                //dd($this->items);
            }
        }
        else {
            //fresh cart
            $storedItem[] = ['pid'=> $pid,'qty'=> 1, 'price'=> $item->price, 'delivery_area'=> $delivery_area, 'delivery_fee'=> $delivery_fee, 'item'=> $item];
            $this->items = $storedItem;
            $this->totalQty++;
            $this->totalPrice += $item->price;
            //dd($this->items);
        }
    }

    public function updateQty($item, $id, $updatedQty, $pid,$delivery_area) {   
        //$item_key = array_search($pid, array_column($this->items, 'pid'));
        foreach ($this->items as $key => $val) {
            //if($val['pid'] == $pid) {
            if($val['pid'] == $pid && $val['delivery_area'] == $delivery_area) {
                $item_key = $key;

                $this->items[$item_key]['qty'] += $updatedQty;
                $this->totalQty = $this->totalQty + $updatedQty;
                $this->totalPrice = $this->totalPrice + $item->price * $updatedQty;
            }
        }        
        //dd($this->totalPrice);
    }

    public function removeItem($pid) {
        foreach ($this->items as $key => $val) {
            if($val['pid'] == $pid) {
                $item_key = $key;                
            }
        }
        $this->totalQty -= $this->items[$item_key]['qty'];
        $this->totalPrice -= $this->items[$item_key]['price'];
        unset($this->items[$item_key]);
    }
}
