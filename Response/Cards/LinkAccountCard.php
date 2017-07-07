<?php
namespace Weysan\Alexa\Response\Cards;

/**
 * Class LinkAccountCard
 * @package Weysan\Alexa\Response\Cards
 */
class LinkAccountCard implements CardInterface
{
    const TYPE = 'LinkAccount';

    /**
     * @return array
     */
    public function getFormatedData()
    {
        return [
            'type' => self::TYPE
        ];
    }
}