<?php
namespace Weysan\Alexa\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Component\HttpFoundation\Request;
use Weysan\Alexa\AlexaIncomingRequest;
use Weysan\Alexa\IntentRegistry;
use Weysan\Alexa\Intents\IntentsInterface;

class IntentRegistryTest extends TestCase
{

    protected $intentsRegistered = [];

    public function tearDown()
    {
        foreach ($this->intentsRegistered as $intentName) {
            IntentRegistry::unregisterIntentHandler($intentName);
        }
        $this->intentsRegistered = [];
    }

    public function testRegisterSimpleIntent()
    {
        $mockIntent = $this->getIntentClassMock();
        IntentRegistry::registerIntentHandler("IntentName", $mockIntent);
        $this->intentsRegistered[] = "IntentName";
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
        $this->intentsRegistered[] = "IntentName";
        $this->assertEquals(
            $mockIntent,
            IntentRegistry::getIntentHandler($this->getAlexaIncomingRequest("FakeIntentNotRegistered"))
        );
    }

    public function testUnregisterUnexistingIntent()
    {
        $this->assertFalse(IntentRegistry::unregisterIntentHandler('noMatterTheName'));
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

        $psr7Factory = new DiactorosFactory();
        $request = Request::create('/', 'POST', array(), array(), array(), array(), $body);
        $psr_request = $psr7Factory->createRequest($request);

        $alexaIncomingRequest = new AlexaIncomingRequest(
            $psr_request
        );
        return $alexaIncomingRequest;
    }
}
