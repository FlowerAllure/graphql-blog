<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog\Type;

use FlowerAllure\GraphqlLearn\Blog\Data\DataSource;
use FlowerAllure\GraphqlLearn\Blog\Module\Story;
use FlowerAllure\GraphqlLearn\Blog\Module\User;
use FlowerAllure\GraphqlLearn\Blog\Type\Enum\StoryAffordancesType;
use FlowerAllure\GraphqlLearn\Blog\Type\Field\HtmlField;
use FlowerAllure\GraphqlLearn\Blog\Types;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
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
                'mentions' => Type::listOf(Types::mention()),
                'comments' => [
                    'type' => Type::listOf(Types::comment()),
                    'args' => [
                        'after' => [
                            'type' => Types::id(),
                        ],
                        'limit' => [
                            'type' => Types::int(),
                            'defaultValue' => 5,
                        ],
                    ],
                ],
                'hasViewerLiked' => Types::boolean(),
                'body' => HtmlField::build('body'),
                'likedBy' => Type::listOf(Types::user()),
                'affordances' => Type::listOf(Types::storyAffordances()),
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

    public function resolveComments(Story $story, array $args): array
    {
        return DataSource::findComments($story->id, $args['limit'], isset($args['after']) ? (int) $args['after'] : null);
    }

    public function resolveHasViewerLiked(Story $story, array $args, $context): bool
    {
        return DataSource::isLikedBy($story->id, $context->viewer->id);
    }

    public function resolveLikedBy(Story $story): array
    {
        return DataSource::findLikes($story->id, 10);
    }

    public function resolveAffordances(Story $story, array $args, $context): array
    {
        $affordances = [];

        $isViewer = $context->viewer === DataSource::findUser($story->authorId);
        if ($isViewer) {
            $affordances[] = StoryAffordancesType::EDIT;
            $affordances[] = StoryAffordancesType::EDIT;
            $affordances[] = StoryAffordancesType::DELETE;
        }

        $isLiked = DataSource::isLikedBy($story->id, $context->viewer->id);
        if ($isLiked) {
            $affordances[] = StoryAffordancesType::UNLIKE;
        } else {
            $affordances[] = StoryAffordancesType::LIKE;
        }

        return $affordances;
    }
}
