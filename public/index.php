<?php
require_once "../vendor/autoload.php";

use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$queryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'echo' => [
            'type' => Type::string(),
            'args' => [
                'message' => Type::nonNull(Type::string()),
            ],
            'resolve' => function ($root, $args) {
                return $root['prefix'] . $args['message'];
            }
        ],
        'id' => [
            "type" => Type::id(),
            "description" => "随机数",
            "resolve" => static fn() => mt_rand(100, 1000)
        ]
    ],
]);


$schema = new Schema([
    'query' => $queryType
]);

$input = json_decode(file_get_contents('php://input'), true);
$query = $input['query'];

try {
    $root = ['prefix' => 'You said: '];
    $result = GraphQL::executeQuery($schema, $query, $root, null, null);
    $output = $result->toArray();
} catch (\Exception $e) {
    $output = [
        'errors' => [
            [
                'message' => $e->getMessage()
            ]
        ]
    ];
}
header('Content-Type: application/json');
echo json_encode($output);
