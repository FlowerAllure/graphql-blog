<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog\Type;

use FlowerAllure\GraphqlLearn\Blog\Module\Image;
use FlowerAllure\GraphqlLearn\Blog\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class ImageType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Image',
            'fields' => [
                'id' => Types::id(),
                'width' => Types::int(),
                'height' => Types::int(),
                'size' => Types::imageSize(),
                'url' => [
                    'type' => Types::url(),
                    'resolve' => [$this, 'resolveUrl'],
                ],
                'name' => [
                    'type' => Types::string(),
                    'resolve' => [$this, 'resolveName'],
                ],
            ],
        ];

        parent::__construct($config);
    }

    public function resolveUrl(Image $value, array $args, $context, ResolveInfo $info): string
    {
        return '/images/user/'.$value->id.'-'.$value->size.'.jpg';
    }

    public function resolveName(Image $value): string
    {
        return $value->name;
    }
}
