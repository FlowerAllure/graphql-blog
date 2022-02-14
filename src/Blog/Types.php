<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog;

use Closure;
use FlowerAllure\GraphqlLearn\Blog\Type\Scalar\EmailType;
use FlowerAllure\GraphqlLearn\Blog\Type\UserType;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Type\Definition\Type;

class Types
{
    private static array $types = [];

    public static function boolean(): ScalarType
    {
        return Type::boolean();
    }

    public static function float(): ScalarType
    {
        return Type::float();
    }

    public static function id(): ScalarType
    {
        return Type::id();
    }

    public static function int(): ScalarType
    {
        return Type::int();
    }

    public static function string(): ScalarType
    {
        return Type::string();
    }

    public static function email(): callable
    {
        return self::get(EmailType::class);
    }

    public static function user(): callable
    {
        return self::get(UserType::class);
    }

    public static function get(string $classname): Closure
    {
        return static fn (): string => self::byClassName($classname);
    }

    public static function byClassName(string $classname): string
    {
        $parts = explode('\\', $classname);
        $cacheName = strtolower(preg_replace('/Type$/', '', $parts[count($parts) - 1]));
        if (!isset(self::$types[$cacheName])) {
            return self::$types[$cacheName] = new $classname();
        }

        return self::$types[$cacheName];
    }
}
