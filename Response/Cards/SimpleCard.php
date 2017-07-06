<?php
namespace Weysan\Alexa\Response\Cards;

/**
 * Class SimpleCard
 * @package Weysan\Alexa\Response\Cards
 */
class SimpleCard implements CardInterface
{
    const TYPE = 'Simple';

    /**
     * @return array
     */
    public function getFormatedData()
    {
        $formated = [
            'type' => self::TYPE,
            'title' => '',
            'content' => ''
        ];

        return $formated;
    }
}