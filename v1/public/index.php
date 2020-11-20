<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('log_errors', 1);

$app = AppFactory::create();

$app->add(function (Request $request, RequestHandler $handler) {
    $response = $handler->handle($request);
    $existingContent = (string) $response->getBody();

    $response = new Response();
    $response->getBody()->write('BEFORE ' . $existingContent);

    return $response;
});

$app->add(function (Request $request, RequestHandler $handler) {
    $response = $handler->handle($request);
    $response->getBody()->write(' AFTER');
    return $response;
});

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write('Hello World');
    return $response;
});

$app->run();