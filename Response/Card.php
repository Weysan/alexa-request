<?php
namespace Weysan\Alexa\Response;

use Weysan\Alexa\Response\Cards\CardInterface;
use Weysan\Alexa\Response\Cards\SimpleCard;
use Weysan\Alexa\Response\Cards\StandardCard;

/**
 * Class Card
 * @package Weysan\Alexa\Response
 */
class Card
{
    /**
     * @param $type
     * @return CardInterface|bool
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
            default:
                return false;
                break;
        }
    }
}