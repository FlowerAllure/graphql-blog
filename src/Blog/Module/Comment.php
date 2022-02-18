<?php


namespace FlowerAllure\GraphqlLearn\Blog\Module;


use GraphQL\Utils\Utils;

class Comment
{
    public int $id;

    public int $authorId;

    public int $storyId;

    public ?int $parentId = null;

    public string $body;

    public bool $isAnonymous = true;

    public function __construct(array $data)
    {
        Utils::assign($this, $data);
    }
}
