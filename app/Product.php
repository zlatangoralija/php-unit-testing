<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $name;
    protected $price;
    protected $description;

    public function __construct($name = null, $price = null, $description = null)
    {
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }

    public function name(){
        return $this->name;
    }

    public function price(){
        return $this->price;
    }

    public function description(){
        return $this->description;
    }
}
