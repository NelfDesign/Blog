<?php
/**
 * Created by IntelliJ IDEA.
 * User: Nelfdesign
 * Date: 24/04/2018
 * Time: 12:26
 */

namespace Framework\Renderer;

class TwigRenderer implements RendererInterface
{
    private $twig;

    private $loader;
    /**
     * TwigRenderer constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->loader = new \Twig_Loader_Filesystem($path);
        $this->twig = new \Twig_Environment($this->loader, []);
    }

    /**
     * permet de charger un chemin pour les vues
     * @param string $namespace
     * @param string $path
     * @return void
     * @throws \Twig_Error_Loader
     */
    public function addPath(string $namespace, ?string $path = null): void
    {
        $this->loader->addPath($path, $namespace);
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
