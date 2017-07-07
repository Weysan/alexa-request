<?php
namespace Weysan\Alexa\Tests\Response;

use PHPUnit\Framework\TestCase;
use Weysan\Alexa\Exceptions\UnexpectedCardTypeException;
use Weysan\Alexa\Response\Card;
use Weysan\Alexa\Response\Cards\LinkAccountCard;
use Weysan\Alexa\Response\Cards\SimpleCard;
use Weysan\Alexa\Response\Cards\StandardCard;

/**
 * Class CardTest
 * @package Weysan\Alexa\Tests\Response
 */
class CardTest extends TestCase
{
    public function testLinkAccountCard()
    {
        $card = new Card();
        $linkAccountCard = $card->getType(LinkAccountCard::TYPE);
        $this->assertEquals([
            'type' => 'LinkAccount'
        ], $linkAccountCard->getFormatedData());
    }

    public function testSimpleCard()
    {
        $card = new Card();
        /**
         * @var SimpleCard $simpleCard
         */
        $simpleCard = $card->getType(SimpleCard::TYPE);

        $simpleCard->setTitle('My title')->setContent('My content');

        $this->assertEquals([
            'type' => 'Simple',
            'title' => 'My title',
            'content' => 'My content'
        ], $simpleCard->getFormatedData());
    }

    public function testStandardCard()
    {
        $card = new Card();
        /**
         * @var StandardCard $simpleCard
         */
        $simpleCard = $card->getType(StandardCard::TYPE);

        $simpleCard->setTitle('My title')->setText('My content')->setImage("http://www.large.url", "http://www.small.url");

        $this->assertEquals([
            'type' => 'Standard',
            'title' => 'My title',
            'text' => 'My content',
            'image' => [
                'smallImageUrl' => "http://www.small.url",
                'largeImageUrl' => "http://www.large.url"
            ]
        ], $simpleCard->getFormatedData());
    }

    /**
     * @expectedException \Weysan\Alexa\Exceptions\UnexpectedCardTypeException
     */
    public function testUnexpectedCard()
    {
        $card = new Card();
        $card->getType('unexpected-card-type');
    }
}