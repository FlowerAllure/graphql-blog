<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog\Type;

use FlowerAllure\GraphqlLearn\Blog\Data\DataSource;
use FlowerAllure\GraphqlLearn\Blog\Module\Image;
use FlowerAllure\GraphqlLearn\Blog\Module\Story;
use FlowerAllure\GraphqlLearn\Blog\Module\User;
use FlowerAllure\GraphqlLearn\Blog\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class UserType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'User',
            'description' => 'Our blog authors',
            'interfaces' => [$node = Types::node()],
            'fields' => static fn (): array => [
                'id' => Types::id(),
                'email' => Types::email(),
                'firstName' => [
                    'type' => Types::string(),
                ],
                'lastName' => [
                    'type' => Types::string(),
                ],
                'name' => [
                    'type' => Types::string(),
                    'resolve' => function (User $user) {
                        return $user->firstName.' '.$user->lastName;
                    },
                ],
                'photo' => [
                    'type' => Types::image(),
                    'args' => [
                        'size' => Type::nonNull(Types::imageSize()),
                    ],
                ],
                'lastStoryPosted' => Types::story(),
                $node()->getField('node')
            ],
            'resolveField' => function ($user, $args, $context, ResolveInfo $info) {
                $fieldName = $info->fieldName;

                $method = 'resolve'.ucfirst($fieldName);
                if (method_exists($this, $method)) {
                    return $this->{$method}($user, $args, $context, $info);
                }

                return $user->{$fieldName};
            },
        ];

        parent::__construct($config);
    }

    public function resolvePhoto(User $user, array $args, $context, ResolveInfo $info): Image
    {
        return DataSource::getUserPhoto($user->id, $args['size']);
    }

    public function resolveLastStoryPosted(User $user): ?Story
    {
        return DataSource::findLastStoryFor($user->id);
    }
}
