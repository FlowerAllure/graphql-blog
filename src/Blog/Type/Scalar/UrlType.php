<?php


namespace FlowerAllure\GraphqlLearn\Blog\Type\Scalar;


use GraphQL\Language\AST\Node;
use GraphQL\Language\AST\ValueNode;
use GraphQL\Type\Definition\ScalarType;

class UrlType extends ScalarType
{
    public function serialize($value)
    {
        return $value;
    }

    public function parseValue($value)
    {
        return $value;
    }

    public function parseLiteral(Node $valueNode, ?array $variables = null)
    {
        return $valueNode->value;
    }
}
