<?php


namespace FlowerAllure\GraphqlLearn\Blog\Type;


use FlowerAllure\GraphqlLearn\Blog\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Query',
            'fields' => [
                'hello' => Type::string(),
            ],
            'resolveField' => function ($rootValue, $args, $context, ResolveInfo $info) {
                return $this->{$info->fieldName}($rootValue, $args, $context, $info);
            },
        ];

        parent::__construct($config);
    }

    public function hello(): string
    {;
        return 'Your graphql-php endpoint is ready! Use a GraphQL client to explore the schema.';
    }
}
