<?php

namespace Framework\HTTP\Router;

use Aura\Router\Exception\RouteNotFound;
use Aura\Router\RouterContainer;
use Framework\HTTP\Router\Exception\RequestNotMatchedException;
use Framework\HTTP\Router\Exception\RouteNotFoundException;
use Psr\Http\Message\ServerRequestInterface;

class AuraRouterAdapter implements Router
{
    private $aura;

    public function __construct(RouterContainer $aura)
    {
        $this->aura = $aura;
    }

    /**
     * @param ServerRequestInterface $request
     * @throws RequestNotMatchedException
     * @return Result
     */
    public function match(ServerRequestInterface $request): Result
    {
        $mather = $this->aura->getMatcher();

        if ($route = $mather->match($request)) {
            return new Result($route->name, $route->handler, $route->attributes);
        }

        throw new RequestNotMatchedException($request);
    }

    /**
     * @param $name
     * @param array $params
     * @throws RouteNotFoundException
     * @return string
     */
    public function generate($name, array $params): string
    {
        $generator = $this->aura->getGenerator();

        try {
            return $generator->generate($name, $params);
        } catch (RouteNotFound $e) {
            throw new RouteNotFoundException($name, $params, $e);
        }
    }

    /**
     * @param RouteData $data
     */
    public function addRoute(RouteData $data): void
    {
        // TODO: Implement addRoute() method.
    }
}