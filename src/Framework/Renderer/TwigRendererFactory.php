<?php

namespace Framework\Renderer;

use Psr\Container\ContainerInterface;

class TwigRendererFactory
{
    /**
     * @param ContainerInterface $container
     * @return TwigRenderer
     */
    public function __invoke(ContainerInterface $container): TwigRenderer
    {
        $view = $container->get('view.path');
        $loader = new \Twig_Loader_Filesystem($view);
        $twig = new \Twig_Environment($loader);
        if ($container->has('twig.extensions')) {
            foreach ($container->get('twig.extensions') as $extension) {
                $twig->addExtension($extension);
            }
        }

        return new TwigRenderer($twig);
    }
}
