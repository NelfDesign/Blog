<?php

namespace Tests\Framework;


use Framework\Renderer;
use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase
{
    private $renderer;

    public function setUp()
    {
        $this->renderer = new Renderer();
        //on crée le system qui permet de creer un chemin
        $this->renderer->addPath(__DIR__ . '\Views');
    }

    public function testRenderTheRightPath(){
        //on crée le system qui permet de creer un chemin
        $this->renderer->addPath('blog', __DIR__ . '\Views');
        //la methode render rend la vue demo
        $content = $this->renderer->render('@blog/demo');
        //on s'attend a avoir
        $this->assertEquals('Salut les gens!', $content);
    }

    public function testRenderTheDefaultPath(){
        //on crée le system qui permet de creer un chemin
        $this->renderer->addPath(__DIR__ . '\Views');
        //la methode render rend la vue demo
        $content = $this->renderer->render('demo');
        //on s'attend a avoir
        $this->assertEquals('Salut les gens!', $content);
    }

    public function testRenderWithParams(){
        //la methode render rend la vue demo
        $content = $this->renderer->render('demoparams', ['nom' => 'Nelf']);
        //on s'attend a avoir
        $this->assertEquals('Salut Nelf', $content);
    }

    public function testGlobalParams(){
        $this->renderer->addGlobals('nom', 'Nelf');
        //la methode render rend la vue demo
        $content = $this->renderer->render('demoparams');
        //on s'attend a avoir
        $this->assertEquals('Salut Nelf', $content);
    }

}