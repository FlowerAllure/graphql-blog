<?php


namespace FlowerAllure\GraphqlLearn\Blog\Type;


use FlowerAllure\GraphqlLearn\Blog\Data\DataSource;
use FlowerAllure\GraphqlLearn\Blog\Module\Comment;
use FlowerAllure\GraphqlLearn\Blog\Module\User;
use FlowerAllure\GraphqlLearn\Blog\Type\Field\HtmlField;
use FlowerAllure\GraphqlLearn\Blog\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class CommentType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Comment',
            'fields' => static fn (): array => [
                'id' => Types::id(),
                'author' => Types::user(),
                'parent' => Types::comment(),
                'isAnonymous' => Types::boolean(),
                'replies' => [
                    'type' => Type::listof(Types::comment()),
                    'args' => [
                        'after' => Types::int(),
                        'limit' => [
                            'type' => Types::int(),
                            'defaultValue' => 5,
                        ],
                    ],
                ],
                'totalReplyCount' => Types::int(),
                'body' => HtmlField::build('body'),
            ],
            'resolveField' => function (Comment $comment, array $args, $context, ResolveInfo $info) {
                $fieldName = $info->fieldName;

                $method = 'resolve' . ucfirst($fieldName);
                if (method_exists($this, $method)) {
                    return $this->{$method}($comment, $args, $context, $info);
                }

                return $comment->{$fieldName};
            },
        ];

        parent::__construct($config);
    }

    public function resolveAuthor(Comment $comment): ?User
    {
        return DataSource::findUser($comment->authorId);
    }

    public function resolveParent(Comment $comment): ?Comment
    {
        return (null !== $comment->parentId) ? DataSource::findComment($comment->parentId) : null;
    }

    public function resolveReplies(Comment $comment, array $args): array
    {
        return DataSource::findReplies($comment->id, $args['limit'], $args['after'] ?? null);
    }

    public function resolveTotalReplyCount(Comment $comment): int
    {
        return DataSource::countReplies($comment->id);
    }
}
