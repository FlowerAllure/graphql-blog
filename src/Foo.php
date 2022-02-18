<?php

namespace FlowerAllure\GraphqlLearn;

use Closure;
use stdClass;

class Foo
{
    public function bar(): Closure
    {
        return static function() {
            var_dump($this);
        };
    }

    public function baz(): Closure
    {
        return function () {
            var_dump($this);
        };
    }
}
//$foo = new Foo();
//$bar = $foo->bar();
//$baz = $foo->baz();
//$bar();
//$baz();

//$a = function() {var_dump($this);};
//$c = $a->bindTo(new stdClass());
//$c();

//$b = static function() {var_dump($this);};
//$d = $b->bindTo(new stdClass());
//$d();
