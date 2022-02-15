<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog\Module;

use GraphQL\Utils\Utils;

class Image
{
    public const SIZE_ICON = 'icon';
    public const SIZE_SMALL = 'small';
    public const SIZE_MEDIUM = 'medium';
    public const SIZE_ORIGINAL = 'original';

    public int $id;

    public string $name;

    public string $type;

    public string $size;

    public int $width;

    public int $height;

    public function __construct(array $data)
    {
        Utils::assign($this, $data);
    }
}
