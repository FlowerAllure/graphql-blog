<?php


namespace FlowerAllure\GraphqlLearn\Test;


use PHPUnit\Framework\TestCase;

class FunctionTest extends TestCase
{
    public function testA()
    {
        $args = ['a'];
        $args += ['after' => null];
        print_r($args);
        $this->assertTrue(true);
    }
}
