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
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use JetBrains\PhpStorm\Pure;

class StoryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Story',
            'fields' => static fn (): array => [
                'id' => Types::id(),
                'author' => Types::user(),
                'totalCommentCount' => Types::int(),
                'mentions' => new ListOfType(Types::mention()),
            ],
            'resolveField' => function (Story $story, array $args, $context, ResolveInfo $info) {
                $fieldName = $info->fieldName;

                $method = 'resolve'.ucfirst($fieldName);
                if (method_exists($this, $method)) {
                    return $this->{$method}($story, $args, $context, $info);
                }

                return $story->{$fieldName};
            },
        ];

        parent::__construct($config);
    }

    public function resolveAuthor(Story $story): ?User
    {
        return DataSource::findUser($story->authorId);
    }

    #[Pure]
 public function resolveTotalCommentCount(Story $story): int
 {
     return DataSource::countComments($story->id);
 }

    public function resolveMentions(Story $story): array
    {
        return DataSource::findStoryMentions($story->id);
    }
}
