<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    /**
     * @var array Liste des modules
     */
    private $modules = [];

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * App constructor.
     * @param ContainerInterface $container
     * @param string[] $modules Liste des modules à charger
     */
    public function __construct(ContainerInterface $container, array $modules = [])
    {
        $this->container = $container;
        foreach ($modules as $module) {
            $this->modules[] = $container->get($module);
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri[-1] === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader('Location', substr($uri, 0, -1));
        }

        $route = $this->container->get(Router::class)->match($request);

        if (is_null($route)) {
            return new Response(404, [], '<h1>ERREUR 404 !!</h1>');
        }

        $params = $route->getParams();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);

        $callback = $route->getCallback();
        if (is_string($callback)) {
            $callback = $this->container->get($callback);
        }

        $response = call_user_func_array($callback, [$request]);
        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception('La réponse n\'est ni une chaine de caractère ni une instance de ResponseInterface');
        }
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}
