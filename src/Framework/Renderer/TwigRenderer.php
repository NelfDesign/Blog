<?php

namespace Framework\Renderer;

class TwigRenderer implements RendererInterface
{
    private $twig;


    /**
     * TwigRenderer constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * permet de charger un chemin pour les vues
     * @param string $namespace
     * @param string $path
     * @return void
     */
    public function addPath(string $namespace, ?string $path = null): void
    {
        $this->twig->getLoader()->addPath($path, $namespace);
    }

    /**
     * permet de rendre les vues
     * @param string $view
     * @param array $params
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function render(string $view, array $params = []): string
    {
        return $this->twig->render($view . '.twig', $params);
    }

    /**
     * permet de rajouter des variables globales à toutes les vues
     * @param string $key
     * @param $value
     */
    public function addGlobals(string $key, $value): void
    {
        $this->twig->addGlobal($key, $value);
    }
}
