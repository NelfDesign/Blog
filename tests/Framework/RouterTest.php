<?php
namespace Tests\Framework;

use Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase {

    /**
     * @var Router
     */
    private $router;

    public function setUp()
    {
        $this->router = new Router();
    }

    /**
     *
     */
    public function testGetMethod()
    {
        //on crée une requete avecla methode GET dont l'url est /blog
        $request = new ServerRequest('GET', '/blog');
        //on crée un router qui dit crée une url avec /blog et appelle la fonction qui retourne hello et dont le nom est blog
        $this->router->get('/blog',function () {return 'Hello';}, 'blog');
        //la methode match va vérifier si une des url matche avec le router
        $route = $this->router->match($request);
        //on verifie si le nom de la route est bien blog
        $this->assertEquals('blog', $route->getName());
        //on verifie si la methode renvoie bien hello
        $this->assertContains('Hello', call_user_func_array($route->getCallback(), [$request]));
    }

    /**
     * même test avec un url qui ne correspond pas
     */
    public function testGetMethodIfUrlDoesNotExist()
    {
        $request = new ServerRequest('GET', '/blog');
        $this->router->get('/blogaze', function () {return 'Hello';}, 'blog');
        $route = $this->router->match($request);
        //la route doit renvoyer null si pas de match
        $this->assertEquals(null, $route);
    }

    public function testGetMethodWithParameters()
    {
        $request = new ServerRequest('GET', '/blog/mon-slug-8');
        $this->router->get('/blog', function () { return 'zaeaea'; }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {return 'Hello';}, 'post.show');
        $route = $this->router->match($request);
        $this->assertEquals('post.show', $route->getName());
        $this->assertEquals('Hello', call_user_func_array($route->getCallBack(), [$request]));
        $this->assertEquals(['slug' => 'mon-slug', 'id' => '8'], $route->getParams());
        //test invalid url
        $route = $this->router->match(new ServerRequest('GET', '/blog/mon_slug-8'));
        $this->assertEquals(null, $route);
    }

    public function testGenerateUri()
    {
        $this->router->get('/blog', function () { return 'zaeaea'; }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {return 'Hello';}, 'post.show');
        $uri = $this->router->generateUri('post.show', ['slug' => 'mon-article', 'id' => 18] );
        $this->assertEquals('/blog/mon-article-18', $uri);
    }

    public function testGenerateUriWithParams()
    {
        $this->router->get('/blog', function () { return 'zaeaea'; }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {return 'Hello';}, 'post.show');
        $uri = $this->router->generateUri(
            'post.show',
            ['slug' => 'mon-article', 'id' => 18],
            ['p' => 2]
        );
        $this->assertEquals('/blog/mon-article-18?p=2', $uri);
    }
}