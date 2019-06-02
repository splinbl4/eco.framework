<?php

use App\Http\Action;

/** @var \Framework\Http\Application $app */
$app->get('home', '/', Action\HelloAction::class);
$app->get('about', '/about', Action\AboutAction::class);
$app->post('create_result', '/create_result', Action\CreateResultAction::class);
$app->get('game', '/game', Action\GamesAction::class);
$app->get('game_page', '/game/page/{page}', Action\GamesAction::class, ['tokens' => ['page' => '\d+']]);
$app->get('result', '/result/{id}', Action\ResultAction::class, ['tokens' => ['id' => '\d+']]);
