<?php
namespace Tests\Framework\Twig;

use Framework\Twig\TextExtension;
use PHPUnit\Framework\TestCase;

class TextExtensionTest extends TestCase
{
    /**
     * @var TextExtension
     */
    private $textExtension;

    public function setUp()
    {
        $this->textExtension = new TextExtension();
    }

    public function testExtrait()
    {
        $text = 'Salut';
        $this->assertEquals($text,$this->textExtension->extrait($text, 10));
    }

    public function testExtraitWithLongText()
    {
        $text = 'Salut les gens';
        $this->assertEquals('Salut ...',$this->textExtension->extrait($text, 7));
        $this->assertEquals('Salut les ...',$this->textExtension->extrait($text, 12));
    }
}