<?php


namespace FlowerAllure\GraphqlLearn\Blog;


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

    public static function get(string $classname)
    {
        return static fn() => self::byClassName($classname);
    }

    public static function byClassName(string $classname)
    {
        $parts = explode('\\', $classname);
        $cacheName = strtolower(preg_replace('~Type$~', '', $parts[count($parts) - 1]));
        if (!isset(self::$types[$cacheName])) {
            return self::$types[$cacheName] = new $classname();
        }

        return self::$types[$cacheName];
    }

    public static function byTypeName(string $shortName): Type
    {
        $cacheName = strtolower($shortName);
        $type = null;

        if (isset(self::$types[$cacheName])) {
            return self::$types[$cacheName];
        }

        $method = lcfirst($shortName);
        if (method_exists(self::class, $method)) {
            $type = self::{$method}();
        }

        if (! $type) {
            throw new \Exception('Unknown graphql type: ' . $shortName);
        }

        return $type;
    }
}
