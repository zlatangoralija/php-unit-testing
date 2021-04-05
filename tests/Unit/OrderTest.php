<?php

namespace Tests\Unit;

use App\Order;
use App\Product;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{

    public function setUp(): void
    {
        $this->order = new Order();
        $product1 = new Product('Keyboard', 20, 'Keyboard description');
        $product2 = new Product('Monitor', 200, 'Monitor description');

        $this->order->add($product1);
        $this->order->add($product2);
    }

    public function testAnOrderConsistsOfProducts()
    {
        $this->assertCount(2, $this->order->products());
    }

    public function testAnOrderCanDetermineTotalCostOfAllProducts(){
        $this->assertEquals(220, $this->order->total());
    }
}
