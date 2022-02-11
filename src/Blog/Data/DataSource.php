<?php


namespace FlowerAllure\GraphqlLearn\Blog\Data;


use FlowerAllure\GraphqlLearn\Blog\Module\Image;
use FlowerAllure\GraphqlLearn\Blog\Module\User;

class DataSource
{
    private static array $users = [];

    public static function init()
    {
        self::$users = [
            1 => new User([
                'id' => 1,
                'email' => 'john@example.com',
                'firstName' => 'John',
                'lastName' => 'Doe',
            ]),
            2 => new User([
                'id' => 2,
                'email' => 'jane@example.com',
                'firstName' => 'Jane',
                'lastName' => 'Doe',
            ]),
            3 => new User([
                'id' => 3,
                'email' => 'john@example.com',
                'firstName' => 'John',
                'lastName' => 'Doe',
            ]),
        ];
    }

    public static function findUser(int $id): ?User
    {
        return self::$users[$id] ?? null;
    }

    public static function getUserPhoto(int $userId, string $size): Image
    {
        return new Image([
            'id' => $userId,
            'type' => Image::TYPE_USER_PIC,
            'size' => $size,
            'width' => rand(100, 200),
            'height' => rand(100, 200),
        ]);
    }
}
