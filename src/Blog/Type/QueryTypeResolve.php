<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog\Type;

use FlowerAllure\GraphqlLearn\Blog\Data\DataSource;
use FlowerAllure\GraphqlLearn\Blog\Module\User;
use FlowerAllure\GraphqlLearn\Blog\Types;
use GraphQL\Type\Definition\ObjectType;

class QueryTypeResolve extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Query',
            'fields' => [
                'hello' => [
                    'type' => Types::string(),
                    'resolve' => [$this, 'hello'],
                ],
                'world' => [
                    'type' => Types::string(),
                    'resolve' => [$this, 'world'],
                ],
            ],
        ];

        parent::__construct($config);
    }

    public function hello(): string
    {
        return 'Hello';
    }

    public function world(): string
    {
        return 'World!';
    }

    public function viewer($rootValue, array $args, $context): User
    {
        return $context->viewer;
    }

    public function user($rootValue, array $args): User
    {
        return DataSource::findUser((int) $args['id']);
    }
}
