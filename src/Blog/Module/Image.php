<?php


namespace FlowerAllure\GraphqlLearn\Blog\Module;


use GraphQL\Utils\Utils;

class Image
{
    public const TYPE_USER_PIC = 'user_pic';

    public const SIZE_ICON = 'icon';
    public const SIZE_SMALL = 'small';
    public const SIZE_MEDIUM = 'medium';
    public const SIZE_ORIGINAL = 'original';

    public int $id;

    public string $type;

    public string $size;

    public int $width;

    public int $height;

    public function __construct(array $data)
    {
        Utils::assign($this, $data);
    }
}
