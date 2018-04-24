<?php

namespace Framework;

class Renderer
{
    const DEFAULT_NAMESPACE = '__MAIN';

    private $paths = [];

    private $globals = [];

    /**
     * permet de charger un chemin pour les vues
     * @param string $namespace
     * @param string $path
     * @return void
     */
    public function addPath(string $namespace, ?string $path = null): void
    {
        if (is_null($path)) {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        } else {
            $this->paths[$namespace] = $path;
        }
    }

    /**
     * permet de rendre les vues
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params = []):string
    {
        if ($this->hasNamespace($view)) {
            $path = $this->replaceNamespace($view) . '.php';
        } else {
            $path = $this->paths[self::DEFAULT_NAMESPACE] . DIRECTORY_SEPARATOR . $view . '.php';
        }
        ob_start();
        $renderer = $this;
        extract($this->globals);
        extract($params);
        require($path);
        return ob_get_clean();
    }

    /**
     * permet de rajouter des variables globales à toutes les vues
     * @param string $key
     * @param $value
     */
    public function addGlobals(string $key, $value): void
    {
        $this->globals[$key] = $value;
    }

    /**
     * @param string $view
     * @return bool
     */
    private function hasNamespace(string $view): bool
    {
        return $view[0] === '@';
    }

    /**
     * @param string $view
     * @return string
     */
    private function getNamespace(string $view): string
    {
        //on retourne le nom du namespace
        //on part du caractére 1 aprés le @ et on cherche avec strpos le nom jusqu'au caractère avant le /
        return substr($view, 1, strpos($view, '/') -1);
    }

    /**
     * @param string $view
     * @return string
     */
    private function replaceNamespace(string $view): string
    {
        //on utilise getNamespace sur la variable pour récupérer le nom du namespace
        $namespace = $this->getNamespace($view);
        return str_replace('@'. $namespace, $this->paths[$namespace], $view);
    }
}
