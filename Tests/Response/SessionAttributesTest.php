<?php
namespace Weysan\Alexa\Tests\Response;

use PHPUnit\Framework\TestCase;
use Weysan\Alexa\Response\SessionAttributes;

class SessionAttributesTest extends TestCase
{
    public function testAddAndGetData()
    {
        $sessionAttributes = new SessionAttributes();
        $sessionAttributes->addAttribute("my_key", "my_value");

        $this->assertEquals("my_value", $sessionAttributes->getAttribute("my_key"));
        $this->assertFalse($sessionAttributes->getAttribute("my_key_random"));

        $sessionAttributes->remove("my_key");

        $this->assertFalse($sessionAttributes->getAttribute("my_key"));
    }

    public function testGetCollectionSession()
    {
        $sessionAttributes = new SessionAttributes();
        $sessionAttributes->addAttribute("my_key", "my_value");
        $sessionAttributes->addAttribute("my_key2", "my_value2");
        $sessionAttributes->addAttribute("my_key3", "my_value3");

        $this->assertEquals([
            "my_key" => "my_value",
            "my_key2" => "my_value2",
            "my_key3" => "my_value3",
        ], $sessionAttributes->getCollection());
    }
}
