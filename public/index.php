<?php

use App\Blog\BlogModule;

require '../vendor/autoload.php';

$renderer = new \Framework\Renderer\TwigRenderer(dirname(__DIR__) . '/Views');


$app = new \Framework\App([
    BlogModule::class
], [
    'renderer' => $renderer
]);

//on crée un objet reponse
$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
//transforme la reponse en PSR7 en objet Http grace au module http-interop/response-sender
\Http\Response\send($response);
