<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog\Type;

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
                'hello' => Type::string(),
            ],
            // 'resolveField' => function ($rootValue, $args, $context, ResolveInfo $info): mixed {
            //    return $this->{$info->fieldName}($rootValue, $args, $context, $info);
            // },
            'resolveField' => fn ($rootValue, $args, $context, ResolveInfo $info): mixed => $this->{$info->fieldName}($rootValue, $args, $context, $info),
        ];

        parent::__construct($config);
    }

    public function hello(): string
    {
        return 'Your graphql-php endpoint is ready! Use a GraphQL client to explore the schema.';
    }
}
