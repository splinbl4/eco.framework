<?php

use App\Http\Action\AboutAction;
use App\Http\Action\HelloAction;
use Aura\Router\RouterContainer;
use Framework\HTTP\ActionResolver;
use Framework\HTTP\Router\AuraRouterAdapter;
use Framework\HTTP\Router\Exception\RequestNotMatchedException;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$aura = new RouterContainer();
$routs = $aura->getMap();

$routs->get('home', '/', HelloAction::class);
$routs->get('about', '/about', AboutAction::class);

$router = new AuraRouterAdapter($aura);
$resolver = new ActionResolver();

$request = ServerRequestFactory::fromGlobals();


try {
    $result = $router->match($request);

    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }

    $action = $resolver->resolve($result->getHandler());

    $response = $action($request);

} catch (RequestNotMatchedException $e) {
    $response = new JsonResponse(['error' => 'Undefined page'], 404);
}

$response = $response->withHeader('X-dev', 'sbykov');

$emitter = new SapiEmitter();
$emitter->emit($response);