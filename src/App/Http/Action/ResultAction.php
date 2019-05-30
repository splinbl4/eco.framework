<?php

namespace App\Http\Action;

use App\Entity\Game;
use App\Repository\GameReadRepository;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class ResultAction implements MiddlewareInterface
{
    private $template;
    private $game;
    private $gameResultRepository;

    public function __construct(TemplateRenderer $template, Game $game, GameReadRepository $gameResultRepository)
    {
        $this->template = $template;
        $this->game = $game;
        $this->gameResultRepository = $gameResultRepository;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        if (!$game = $this->gameResultRepository->find($request->getAttribute('id'))) {
            return $handler->handle($request);
        }

        return new HtmlResponse($this->template->render('app/result', ['game' => $game]));
    }
}