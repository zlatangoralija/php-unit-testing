<?php

namespace Tests\Unit;

use App\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{

    //Setup method, which wil load first. We can setup common data here.
    public function setUp(): void
    {
        $this->product = new Product('John', 69, 'Description');
    }

    //Actual test. In order to run, it must begin with 'test' in the name
    public function testProductHasName()
    {
        $this->assertEquals('John', $this->product->name());
    }

    public function testProductHasPrice()
    {

        $this->assertEquals(69, $this->product->price());
    }

    //If a function name doesn't include 'test' at the beginning, we can still call it by using test notation, which
    //tells phpunit that this is a test indeed
    /** @test */
    public function productHasDescription(){
        $this->assertEquals('Description', $this->product->description());
    }

}
