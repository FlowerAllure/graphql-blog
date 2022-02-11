<?php


namespace FlowerAllure\GraphqlLearn\Blog\Type\Scalar;


use GraphQL\Language\AST\Node;
use GraphQL\Language\AST\ValueNode;
use GraphQL\Type\Definition\ScalarType;

class EmailType extends ScalarType
{
    // 序列化值
    public function serialize($value)
    {
        return $value;
    }

    // 解析外部输入的值
    public function parseValue($value)
    {
        return $value;
    }

    // 解析外部输入的文字变量值
    public function parseLiteral(Node $valueNode, ?array $variables = null)
    {
        return $valueNode->value;
    }
}