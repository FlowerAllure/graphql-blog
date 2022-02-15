<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog\Module;

use GraphQL\Utils\Utils;

class Story
{
    public int $id;

    public int $authorId;

    public string $title;

    public string $body;

    public bool $isAnonymous = false;

    public function __construct(array $data)
    {
        Utils::assign($this, $data);
    }
}
