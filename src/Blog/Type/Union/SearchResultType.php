<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog\Type\Union;

use Exception;
use FlowerAllure\GraphqlLearn\Blog\Module\Story;
use FlowerAllure\GraphqlLearn\Blog\Module\User;
use FlowerAllure\GraphqlLearn\Blog\Types;
use GraphQL\Type\Definition\UnionType;

class SearchResultType extends UnionType
{
    public function __construct()
    {
        $config = [
            'name' => 'SearchResult',
            'types' => static fn (): array => [
                Types::story(),
                Types::user(),
            ],
            'resolveType' => static function (object $value): callable {
                if ($value instanceof Story) {
                    return Types::story();
                }
                if ($value instanceof User) {
                    return Types::user();
                }
                throw new Exception('Unknown type: '.get_class($value));
            },
        ];
        parent::__construct($config);
    }
}
