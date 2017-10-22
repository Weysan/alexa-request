<?php
namespace Weysan\Alexa\Response;

use Weysan\Alexa\Exceptions\UnexpectedCardTypeException;
use Weysan\Alexa\Response\Cards\CardInterface;
use Weysan\Alexa\Response\Cards\LinkAccountCard;
use Weysan\Alexa\Response\Cards\SimpleCard;
use Weysan\Alexa\Response\Cards\StandardCard;

/**
 * Class Card
 * @package Weysan\Alexa\Response
 */
class Card
{
    /**
     * @param string $type
     * @return CardInterface
     * @throws UnexpectedCardTypeException
     */
    public function getType($type)
    {
        switch ($type)
        {
            case SimpleCard::TYPE:
                return new SimpleCard();
                break;
            case StandardCard::TYPE:
                return new StandardCard();
                break;
            case LinkAccountCard::TYPE:
                return new LinkAccountCard();
                break;
            default:
                throw new UnexpectedCardTypeException($type);
                break;
        }
    }
}