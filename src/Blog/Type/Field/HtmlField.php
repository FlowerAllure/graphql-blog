<?php

namespace FlowerAllure\GraphqlLearn\Blog\Type\Field;

use FlowerAllure\GraphqlLearn\Blog\Type\Enum\ContentFormatType;
use FlowerAllure\GraphqlLearn\Blog\Types;
use JetBrains\PhpStorm\ArrayShape;

class HtmlField
{
    #[ArrayShape([
        'type' => "\GraphQL\Type\Definition\ScalarType",
        'args' => "array",
        'resolve' => "\Closure"
    ])]
    public static function build(string $objectKey): array
    {
        return [
            'type' => Types::string(),
            'args' => [
                'format' => [
                    'type' => Types::contentFormat(),
                    'defaultValue' => ContentFormatType::FORMAT_HTML,
                ],
                'maxLength' => Types::int(),
            ],
            'resolve' => static function ($object, $args) use ($objectKey) {
                $html = $object->{$objectKey};
                $text = strip_tags($html);

                $safeText = isset($args['maxLength']) ? mb_substr($text, 0, $args['maxLength']) : $text;

                return match ($args['format']) {
                    ContentFormatType::FORMAT_HTML => ($safeText !== $text) ? nl2br($safeText) : $html,
                    default => $safeText,
                };
            }
        ];
    }
}
