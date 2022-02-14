<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog\Module;

use GraphQL\Utils\Utils;

class User
{
    public ?int $id = null;

    public string $email = '';

    public string $firstName = '';

    public string $lastName = '';

    public ?bool $hasPhoto = null;

    public function __construct(array $data)
    {
        Utils::assign($this, $data);
    }
}
