<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog\Type;

use FlowerAllure\GraphqlLearn\Blog\Types;
use GraphQL\Type\Definition\ObjectType;

class UserType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'User',
            'description' => 'Our blog authors',
            'fields' => static fn (): array => [
                'id' => Types::id(),
                'email' => Types::email(),
                'firstName' => [
                    'type' => Types::string(),
                ],
                'lastName' => [
                    'type' => Types::string(),
                ],
            ],
        ];

        parent::__construct($config);
    }
}
