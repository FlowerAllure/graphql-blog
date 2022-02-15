<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog\Type;

use FlowerAllure\GraphqlLearn\Blog\Module\Image;
use GraphQL\Type\Definition\EnumType;

class ImageSizeType extends EnumType
{
    public function __construct()
    {
        $config = [
            'values' => [
                'ICON' => Image::SIZE_ICON,
                'SMALL' => Image::SIZE_SMALL,
                'MEDIUM' => Image::SIZE_MEDIUM,
                'ORIGINAL' => Image::SIZE_ORIGINAL,
            ],
        ];
        parent::__construct($config);
    }
}
