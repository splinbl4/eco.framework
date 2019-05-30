<?php

namespace App\Http\Action;

use App\Entity\Game;
use App\Service\Game\GameService;
use App\UseCase\Collection\EcoCollection;
use App\UseCase\Location;
use App\Validations\GameValidation;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Http\Router\Router;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;

class CreateResultAction implements RequestHandlerInterface
{
    private $entityManager;
    private $template;
    private $gameService;
    private $validation;
    private $router;

    public function __construct(
        EntityManagerInterface $entityManager,
        TemplateRenderer $template,
        GameService $gameService,
        GameValidation $validation,
        Router $router
    )
    {
        $this->entityManager = $entityManager;
        $this->template = $template;
        $this->gameService = $gameService;
        $this->validation = $validation;
        $this->router = $router;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();
        $game = new Game();

        if (!$this->validation->valid($data)) {
            $messages = $this->validation->getMessages();

            return new HtmlResponse($this->template->render('app/hello', ['messages' => $messages]));
        }

        $this->gameService->create($game, $data);

        $location = new Location($game->getSizeField());

        $ecoCollection = EcoCollection::createCollection($location);

        $this->gameService->play($ecoCollection, $location, $game);

        return new RedirectResponse($this->router->generate('result', ['id' => $game->getId()]));
    }
}