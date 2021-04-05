<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $products = [];

    public function add($product){
        $this->products[] = $product;
    }

    public function products(){
        return $this->products;
    }

    public function total(){

        return array_reduce($this->products(), function ($sum, $product){
            return $sum + $product->price();
        });
    }
}
