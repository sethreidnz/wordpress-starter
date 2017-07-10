<?php
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testExample()
    {
        $stack = [];
        $this->assertEquals(0, count($stack));
    }
}
?>