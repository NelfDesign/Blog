<?php

namespace Framework\Twig;

class TextExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters(): array
    {
        return [
            new \Twig_SimpleFilter('extrait', [$this, 'extrait'])
        ];
    }

    /**
     * @param string $content
     * @param int $maxLength
     * @return string
     */
    public function extrait(string $content, int $maxLength = 100): string
    {
        if (mb_strlen($content) > $maxLength) {
            $extrait = mb_substr($content, 0, $maxLength);
            $lastSpace = mb_strrpos($extrait, ' ');
            return mb_substr($extrait, 0, $lastSpace) . ' ...';
        }
        return $content;
    }
}
