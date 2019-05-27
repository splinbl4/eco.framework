<?php

namespace App\Http\Action;

use App\Entity\Game;
use App\Service\Game\GameService;
use App\Validations\GameValidation;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class CreateResultAction implements RequestHandlerInterface
{
    private $entityManager;
    private $template;
    private $gameService;
    private $validation;

    public function __construct(
        EntityManagerInterface $entityManager,
        TemplateRenderer $template,
        GameService $gameService,
        GameValidation $validation
    )
    {
        $this->entityManager = $entityManager;
        $this->template = $template;
        $this->gameService = $gameService;
        $this->validation = $validation;
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

        return new HtmlResponse($this->template->render('app/about'));
    }
}