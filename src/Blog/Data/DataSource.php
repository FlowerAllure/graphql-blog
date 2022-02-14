<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog\Data;

use FlowerAllure\GraphqlLearn\Blog\Module\User;

class DataSource
{
    private static array $users = [];

    public static function init(): void
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
}
