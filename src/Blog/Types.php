<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog;

use Closure;
use FlowerAllure\GraphqlLearn\Blog\Type\CommentType;
use FlowerAllure\GraphqlLearn\Blog\Type\Enum\ContentFormatType;
use FlowerAllure\GraphqlLearn\Blog\Type\Enum\ImageSizeType;
use FlowerAllure\GraphqlLearn\Blog\Type\Enum\StoryAffordancesType;
use FlowerAllure\GraphqlLearn\Blog\Type\ImageType;
use FlowerAllure\GraphqlLearn\Blog\Type\Interfaces\NodeType;
use FlowerAllure\GraphqlLearn\Blog\Type\Scalar\EmailType;
use FlowerAllure\GraphqlLearn\Blog\Type\Scalar\UrlType;
use FlowerAllure\GraphqlLearn\Blog\Type\Union\SearchResultType;
use FlowerAllure\GraphqlLearn\Blog\Type\StoryType;
use FlowerAllure\GraphqlLearn\Blog\Type\UserType;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Type\Definition\Type;
use JetBrains\PhpStorm\Pure;

final class Types
{
    private static array $types = [];

    private static function byClassName(string $classname): Type
    {
        $parts = explode('\\', $classname);
        $cacheName = strtolower(preg_replace('/Type$/', '', $parts[count($parts) - 1]));

        if (!isset(self::$types[$cacheName])) {
            return self::$types[$cacheName] = new $classname();
        }

        return self::$types[$cacheName];
    }

    private static function get(string $classname): Closure
    {
        return static fn (): Type => self::byClassName($classname);
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

    public static function boolean(): ScalarType
    {
        return Type::boolean();
    }

    #[Pure]
    public static function imageSize(): Closure
    {
        return self::get(ImageSizeType::class);
    }

    #[Pure]
    public static function contentFormat(): Closure
    {
        return self::get(ContentFormatType::class);
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

    #[Pure]
    public static function image(): Closure
    {
        return self::get(ImageType::class);
    }

    #[Pure]
    public static function url(): callable
    {
        return self::get(UrlType::class);
    }

    #[Pure]
    public static function story(): Closure
    {
        return self::get(StoryType::class);
    }

    #[Pure]
    public static function mention(): Closure
    {
        return self::get(SearchResultType::class);
    }

    #[Pure]
    public static function comment(): Closure
    {
        return self::get(CommentType::class);
    }

    #[Pure]
    public static function node(): Closure
    {
        return self::get(NodeType::class);
    }

    #[Pure]
    public static function storyAffordances(): callable
    {
        return self::get(StoryAffordancesType::class);
    }
}
