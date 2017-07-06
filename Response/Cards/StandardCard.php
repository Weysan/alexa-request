<?php
namespace Weysan\Alexa\Response\Cards;

/**
 * Class StandardCard
 * @package Weysan\Alexa\Response\Cards
 */
class StandardCard implements CardInterface
{
    const TYPE = 'Standard';

    /**
     * @return array
     */
    public function getFormatedData()
    {
        $formated = [
            'type' => self::TYPE,
            'title' => '',
            'text' => '',
            'image' => [
                'smallImageUrl' => '',
                'largeImageUrl' => ''
            ]
        ];

        return $formated;
    }
}