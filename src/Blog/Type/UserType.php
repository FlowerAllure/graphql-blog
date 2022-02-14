<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog\Type;

use FlowerAllure\GraphqlLearn\Blog\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

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
            //'resolveField' => function ($user, $args, $context, ResolveInfo $info) {
            //    return $user->{$info->fieldName};
            //},
        ];

        parent::__construct($config);
    }
}
