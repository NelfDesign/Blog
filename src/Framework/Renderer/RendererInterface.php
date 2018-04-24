<?php
/**
 * Created by IntelliJ IDEA.
 * User: Nelfdesign
 * Date: 24/04/2018
 * Time: 12:20
 */

namespace Framework\Renderer;

interface RendererInterface
{
    /**
     * permet de charger un chemin pour les vues
     * @param string $namespace
     * @param string $path
     * @return void
     */
    public function addPath(string $namespace, ?string $path = null): void;

    /**
     * permet de rendre les vues
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params = []): string;

    /**
     * permet de rajouter des variables globales à toutes les vues
     * @param string $key
     * @param $value
     */
    public function addGlobals(string $key, $value): void;
}
