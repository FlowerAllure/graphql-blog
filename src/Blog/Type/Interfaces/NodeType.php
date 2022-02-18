<?php

namespace FlowerAllure\GraphqlLearn\Blog\Type\Interfaces;

use Exception;
use FlowerAllure\GraphqlLearn\Blog\Module\Image;
use FlowerAllure\GraphqlLearn\Blog\Module\Story;
use FlowerAllure\GraphqlLearn\Blog\Module\User;
use FlowerAllure\GraphqlLearn\Blog\Types;
use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Utils\Utils;
use JsonException;

class NodeType extends InterfaceType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Node',
            'fields' => [
                'id' => Types::id(),
                'node' => [
                    'type' => Types::string(),
                    'resolve' => function () {
                        return 'Node Interface Type';
                    },
                ]
            ],
            'resolveType' => [$this, 'resolveNodeType'],
        ]);
    }

    /**
     * @throws JsonException
     */
    public function resolveNodeType($object): callable|\Closure
    {
        if ($object instanceof User) {
            return Types::user();
        }

        if ($object instanceof Image) {
            return Types::image();
        }

        if ($object instanceof Story) {
            return Types::story();
        }

        throw new Exception('Unknown type: ' . Utils::printSafe($object));
    }
}
