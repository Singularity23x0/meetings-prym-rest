<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App;

$app->get(
    '/hello/{name}',
    function (Request $request, Response $response, array $args) {
        $name = $args['name'];
        $response->getBody()->write("Hello, $name");
        return $response;
    }
);

$app->get(
    '/api/participants',
    function (Request $request, Response $response, array $args) {
        $participants = [
            ['id' => 1, 'firstname' => 'John', 'lastname' => 'Doe'],
            ['id' => 2, 'firstname' => 'Kate', 'lastname' => 'Pig'],
            ['id' => 3, 'firstname' => 'Chris', 'lastname' => 'Lualigi'],
            ['id' => 4, 'firstname' => 'Author', 'lastname' => 'McFakename']
        ];
        return $response->withJson($participants);
    }
);

$app->get(
    '/api/participants/{id}',
    function (Request $request, Response $response, array $args) {
        $participants = [
            ['id' => 1, 'firstname' => 'John', 'lastname' => 'Doe'],
            ['id' => 2, 'firstname' => 'Kate', 'lastname' => 'Pig'],
            ['id' => 3, 'firstname' => 'Chris', 'lastname' => 'Lualigi'],
            ['id' => 4, 'firstname' => 'Author', 'lastname' => 'McFakename']
        ];
        $id = $args['id'];
        return $response->withJson($participants[$id]);
    }
);

$app->run();