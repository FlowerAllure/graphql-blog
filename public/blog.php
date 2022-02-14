<?php

/*
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use FlowerAllure\GraphqlLearn\Blog\Data\DataSource;
use FlowerAllure\GraphqlLearn\Blog\Type\QueryType;
use FlowerAllure\GraphqlLearn\Blog\Types;
use GraphQL\Server\StandardServer;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;

require_once '../vendor/autoload.php';

try {
    DataSource::init();

    $schema = new Schema([
        'query' => new QueryType()
    ]);

    $appContext = new stdClass();
    $appContext->viewer = DataSource::findUser(1);

    $server = new StandardServer([
        'schema' => $schema,
        'context' => $appContext,
    ]);

    $server->handleRequest();
} catch (Throwable $error) {
    var_dump($error->getMessage());
    StandardServer::send500Error($error);
}
