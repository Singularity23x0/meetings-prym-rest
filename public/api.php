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

class MyDB extends SQLite3 {
    function __construct() {
        $this->open('../participants.db');
    }
}
$db = new MyDB();
if(!$db) {
    echo $db->lastErrorMsg();
    exit();
}

$app->get(
    '/api/participants',
    function (Request $request, Response $response, array $args) use ($db) {

        $participants = [];

        $sql = "SELECT id, firstname, lastname FROM participant";
        $ret = $db->query($sql);
        while($row = $ret->fetchArray(SQLITE3_ASSOC)){
            $participants[] = [
               'id' => $row['id'],
                'firstname' => $row['firstname'],
                'lastname' => $row['lastname']
            ];
        }

        return $response->withJson($participants);
    }
);

$app->get(
    '/api/participants/{id}',
    function (Request $request, Response $response, array $args) use ($db) {

        $sql = "SELECT * FROM participant where id = $args[id]";
        $ret = $db->query($sql);
        if($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $participant = [
                'id' => $row['id'],
                'firstname' => $row['firstname'],
                'lastname' => $row['lastname']
            ];
            return $response->withJson($participant);
        }
        else {
            return $response->withStatus(404);
        }
    }
);

$app->post(
    '/api/participants',
    function (Request $request, Response $response) use ($db) {
        $requestData = $request->getParsedBody();
        $sql = "INSERT INTO participant (firstname, lastname) VALUES ('$requestData[firstname]','$requestData[lastname]')";
        $db->exec($sql);
        return $response->withStatus(201);
    }
);

$app->run();