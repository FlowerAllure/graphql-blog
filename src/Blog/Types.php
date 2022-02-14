<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog;

use Closure;
use Exception;
use FlowerAllure\GraphqlLearn\Blog\Type\Scalar\EmailType;
use FlowerAllure\GraphqlLearn\Blog\Type\UserType;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Type\Definition\Type;
use JetBrains\PhpStorm\Pure;

final class Types
{
    private static array $types = [];

    private static function get(string $classname): Closure
    {
        return static fn (): Type => new $classname;
    }

    public static function id(): ScalarType
    {
        return Type::id();
    }

    public static function string(): ScalarType
    {
        return Type::string();
    }

    #[Pure]
    public static function user(): callable
    {
        return self::get(UserType::class);
    }

    #[Pure]
    public static function email(): callable
    {
        return self::get(EmailType::class);
    }
}
