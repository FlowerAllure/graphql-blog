<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog\Data;

use FlowerAllure\GraphqlLearn\Blog\Module\Image;
use FlowerAllure\GraphqlLearn\Blog\Module\Story;
use FlowerAllure\GraphqlLearn\Blog\Module\User;
use JetBrains\PhpStorm\Pure;

class DataSource
{
    private static array $users = [];

    private static array $stories = [];

    private static array $storyComments = [];

    private static array $storyMentions = [];

    public static function init(): void
    {
        self::$users = [
            1 => new User(['id' => 1, 'email' => 'john@example.com', 'firstName' => 'John', 'lastName' => 'Doe']),
            2 => new User(['id' => 2, 'email' => 'jane@example.com', 'firstName' => 'Jane', 'lastName' => 'Doe']),
            3 => new User(['id' => 3, 'email' => 'john@example.com', 'firstName' => 'John', 'lastName' => 'Doe']),
        ];

        self::$stories = [
            1 => new Story(['id' => 1, 'authorId' => 1, 'body' => '<h1>GraphQL is awesome!</h1>']),
            2 => new Story(['id' => 2, 'authorId' => 1, 'body' => '<a>Test this</a>']),
            3 => new Story(['id' => 3, 'authorId' => 3, 'body' => "This\n<br>story\n<br>spans\n<br>newlines"]),
        ];

        self::$storyComments = [1 => [100, 200, 300], 2 => [400, 500]];

        self::$storyMentions = [1 => [self::$stories[1], self::$users[3]], 2 => [self::$users[2]]];
    }

    public static function findUser(int $id): ?User
    {
        return self::$users[$id] ?? null;
    }

    public static function findLastStoryFor(int $authorId): ?Story
    {
        $storiesFound = array_filter(
            self::$stories,
            static fn (Story $story): bool => $story->authorId === $authorId
        );

        return $storiesFound[count($storiesFound) - 1] ?? null;
    }

    #[Pure]
    public static function countComments(int $storyId): int
    {
        return isset(self::$storyComments[$storyId]) ? count(self::$storyComments[$storyId]) : 0;
    }

    public static function findStoryMentions(int $storyId): array
    {
        return self::$storyMentions[$storyId] ?? [];
    }

    public static function getUserPhoto(int $userId, string $size): Image
    {
        return new Image([
            'id' => $userId,
            'name' => $size.'图片',
            'size' => $size,
            'width' => rand(100, 200),
            'height' => rand(100, 200),
        ]);
    }
}
