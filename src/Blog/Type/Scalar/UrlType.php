<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FlowerAllure\GraphqlLearn\Blog\Type\Scalar;

use GraphQL\Language\AST\Node;
use GraphQL\Type\Definition\ScalarType;

class UrlType extends ScalarType
{
    public function serialize($value)
    {
        return $value;
    }

    public function parseValue($value)
    {
        // TODO: Implement parseValue() method.
    }

    public function parseLiteral(Node $valueNode, ?array $variables = null)
    {
        // TODO: Implement parseLiteral() method.
    }
}
