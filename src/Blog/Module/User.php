<?php


namespace FlowerAllure\GraphqlLearn\Blog\Module;

use GraphQL\Utils\Utils;

class User
{
    public int $id;

    public string $email;

    public string $firstName;

    public string $lastName;

    public bool $hasPhoto;

    public function __construct(array $data)
    {
        Utils::assign($this, $data);
    }
}
