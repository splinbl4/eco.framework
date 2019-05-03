<?php

use App\Http\Action\AboutAction;
use App\Http\Action\HelloAction;
use Framework\Http\Application;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

/**
 * @var \Psr\Container\ContainerInterface $container
 * @var \Framework\Http\Application $app
 */

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = require 'config/container.php';
$app = $container->get(Application::class);

require 'config/pipeline.php';
//require 'config/routes.php';
$app->get('home', '/', HelloAction::class);
$app->get('about', '/about', AboutAction::class);

$request = ServerRequestFactory::fromGlobals();
$response = $app->handle($request);

$emitter = new SapiEmitter();
$emitter->emit($response);
