<?php
namespace Weysan\Alexa\Response\Cards;

/**
 * Class SimpleCard
 * @package Weysan\Alexa\Response\Cards
 */
class SimpleCard implements CardInterface
{
    const TYPE = 'Simple';

    protected $title;

    protected $content;

    /**
     * @return array
     */
    public function getFormatedData()
    {
        $formated = [
            'type' => self::TYPE,
            'title' => $this->title,
            'content' => $this->content
        ];

        return $formated;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
}