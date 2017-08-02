<?php
namespace Weysan\Alexa\Response\Cards;

/**
 * Class StandardCard
 * @package Weysan\Alexa\Response\Cards
 */
class StandardCard implements CardInterface
{
    const TYPE = 'Standard';

    protected $title;

    protected $text;

    protected $smallImageUrl;

    protected $largeImageUrl;

    /**
     * @return array
     */
    public function getFormatedData()
    {
        $formated = [
            'type' => self::TYPE,
            'title' => $this->title,
            'text' => $this->text,
            'image' => [
                'smallImageUrl' => $this->smallImageUrl,
                'largeImageUrl' => $this->largeImageUrl
            ]
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
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param string $largeUrl
     * @param string $smallUrl
     * @return $this
     */
    public function setImage($largeUrl, $smallUrl)
    {
        $this->largeImageUrl = $largeUrl;
        $this->smallImageUrl = $smallUrl;
        return $this;
    }
}