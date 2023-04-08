<?php

namespace Tests\Model;

use App\Model\OrderNumbers;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderNumbersTest extends KernelTestCase
{

    private OrderNumbers $orderNumbers;

    public function setUp(): void
    {
        parent::setUp();
        $container = static::getContainer();
        $this->orderNumbers = $container->get(OrderNumbers::class);
    }

    public function testSort(): void
    {
        $input = [
            '0' => 'ahoj1',
            '1' => 'Ahoj10',
            '2' => 'ahoj12',
            '3' => 'Ahoj2',
            '4' => 'ahoj3',
        ];
        $output = [
            '0' => 'ahoj1',
            '3' => 'Ahoj2',
            '4' => 'ahoj3',
            '1' => 'Ahoj10',
            '2' => 'ahoj12',
        ];
        $this->assertSame($output,$this->orderNumbers->sort($input));
    }

}