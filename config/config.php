<?php

use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router;

return [
    'database.host' => 'localhost',
    'database.username' => 'root',
    'database.password' => '',
    'database.name' => 'grafblog',
    'view.path' => dirname(__DIR__) . '/Views',
    'twig.extensions' => [
        \DI\get(Router\RouterTwigExtension::class)
    ],
    Router::class => \DI\object(),
    RendererInterface::class => \DI\factory(TwigRendererFactory::class)
];