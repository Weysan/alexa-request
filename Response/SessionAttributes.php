<?php
namespace Weysan\Alexa\Response;

/**
 * Class SessionAttributes
 * @package Weysan\Alexa\Response
 */
class SessionAttributes
{
    protected $session = [];

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function addAttribute($key, $value)
    {
        $this->session[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return bool|mixed
     */
    public function getAttribute($key)
    {
        if (key_exists($key, $this->session)) {
            return $this->session[$key];
        }
        return false;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function remove($key)
    {
        if (key_exists($key, $this->session)) {
            unset($this->session[$key]);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getCollection()
    {
        return $this->session;
    }
}
