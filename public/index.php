<?php
//use pointe vers le namespace utilisé
use Framework\App;

require '../vendor/autoload.php';

$app = new App();

$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
\Http\Response\send($response);
