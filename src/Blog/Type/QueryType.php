<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog\Type;

use FlowerAllure\GraphqlLearn\Blog\Data\DataSource;
use FlowerAllure\GraphqlLearn\Blog\Module\User;
use FlowerAllure\GraphqlLearn\Blog\Types;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Query',
            'fields' => [
                'hello' => Types::string(),
                'world' => Types::string(),
                'viewer' => [
                    'type' => Types::user()
                ],
                'user' => [
                    'type' => Types::user(),
                    'args' => [
                        'id' => Type::nonNull(Types::id())
                    ]
                ]
            ],
            'resolveField' => fn ($rootValue, $args, $context, ResolveInfo $info): mixed => $this->{$info->fieldName}($rootValue, $args, $context, $info),
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
