<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog\Type;

use FlowerAllure\GraphqlLearn\Blog\Data\DataSource;
use FlowerAllure\GraphqlLearn\Blog\Module\Story;
use FlowerAllure\GraphqlLearn\Blog\Module\User;
use FlowerAllure\GraphqlLearn\Blog\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use JetBrains\PhpStorm\Pure;

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
                    'type' => Types::user(),
                ],
                'user' => [
                    'type' => Types::user(),
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                    ],
                ],
                'lastStoryPosted' => [
                    'type' => Types::story(),
                    'description' => 'Returns last story posted for this blog',
                ],
                'deprecatedField' => [
                    'type' => Types::string(),
                    'deprecationReason' => 'This field is deprecated!',
                ],
                'stories' => [
                    'type' => Type::listOf(Types::story()),
                    'description' => 'Returns subset of stories posted for this blog',
                    'args' => [
                        'after' => [
                            'type' => Types::id(),
                            'description' => 'Fetch stories listed after the story with this ID',
                        ],
                        'limit' => [
                            'type' => Types::int(),
                            'description' => 'Number of stories to be returned',
                            'defaultValue' => 10,
                        ],
                    ],
                ],
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

    public function deprecatedField(): string
    {
        return 'You can request deprecated field, but it is not displayed in auto-generated documentation by default.';
    }

    public function lastStoryPosted(): ?Story
    {
        return DataSource::findLatestStory();
    }

    #[Pure]
    public function stories($rootValue, array $args): array
    {
        return DataSource::findStories(
            $args['limit'],
            isset($args['after'])
                ? (int) $args['after']
                : null
        );
    }
}
