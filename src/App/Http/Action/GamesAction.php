<?php

namespace App\Http\Action;

use App\Repository\GameReadRepository;
use App\Repository\Pagination;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class GamesAction implements RequestHandlerInterface
{
    private const PER_PAGE = 10;

    private $template;
    private $gameResultRepository;

    public function __construct(GameReadRepository $gameResultRepository, TemplateRenderer $template)
    {
        $this->template = $template;
        $this->gameResultRepository = $gameResultRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $pager = new Pagination(
            $this->gameResultRepository->countAll(),
            $request->getAttribute('page') ?: 1,
            self::PER_PAGE
        );

        $games = $this->gameResultRepository->all(
            $pager->getOffset(),
            $pager->getLimit()
        );

        return new HtmlResponse($this->template->render('app/games', [
            'games' => $games,
            'pager' => $pager,
        ]));
    }

}
