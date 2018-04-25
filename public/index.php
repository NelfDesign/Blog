<?php

use App\Blog\BlogModule;

require '../vendor/autoload.php';

$modules = [
    BlogModule::class
];

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions(dirname(__DIR__) . '/config/config.php');

foreach ($modules as $module) {
    if ($module::DEFINITIONS) {
        $builder->addDefinitions($module::DEFINITIONS);
    }
}
$builder->addDefinitions(dirname(__DIR__) . '/config.php');

$container = $builder->build();


$app = new \Framework\App($container, $modules);

//on crée un objet reponse
$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
//transforme la reponse en PSR7 en objet Http grace au module http-interop/response-sender
\Http\Response\send($response);
