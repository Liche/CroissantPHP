<?php

require_once "app/Bootstrap.php";

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->register();

$bootstrap = new Bootstrap();
$bootstrap->boot();
