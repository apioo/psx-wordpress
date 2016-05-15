<?php

$loader = require(__DIR__ . '/../vendor/autoload.php');
$loader->add('WordpressGateway', 'tests');

\PSX\Framework\Test\Environment::setup(__DIR__ . '/..', function ($fromSchema) {

    return \WordpressGateway\TestSchema::getSchema();

});
