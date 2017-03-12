<?php
namespace Weysan\Alexa\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Weysan\Alexa\AlexaIncomingRequest;
use Weysan\Alexa\IntentRegistry;
use Weysan\Alexa\Intents\IntentsInterface;

class IntentRegistryTest extends TestCase
{
    public function testRegisterSimpleIntent()
    {
        $mockIntent = $this->getIntentClassMock();
        IntentRegistry::registerIntentHandler("IntentName", $mockIntent);

        $this->assertEquals(
            $mockIntent,
            IntentRegistry::getIntentHandler($this->getAlexaIncomingRequest("IntentName"))
        );
    }

    /**
     * @expectedException \Exception
     */
    public function testGettingWrongIntent()
    {
        $mockIntent = $this->getIntentClassMock();
        IntentRegistry::registerIntentHandler("IntentName", $mockIntent);

        $this->assertEquals(
            $mockIntent,
            IntentRegistry::getIntentHandler($this->getAlexaIncomingRequest("FakeIntentNotRegistered"))
        );
    }

    protected function getIntentClassMock()
    {
        $intentMock = \Mockery::mock(IntentsInterface::class);
        return $intentMock;
    }

    protected function getAlexaIncomingRequest($intentName)
    {
        $body = json_encode([
            "request" => [
                "intent" => [
                        "name" => $intentName
                    ]
                ]
        ]);

        $alexaIncomingRequest = new AlexaIncomingRequest(
            new Request(array(), array(), array(), array(), array(), array(), $body)
        );
        return $alexaIncomingRequest;
    }
}
