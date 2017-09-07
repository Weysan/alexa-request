<?php
namespace Weysan\Alexa\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Component\HttpFoundation\Request;
use Weysan\Alexa\AlexaIncomingRequest;
use Weysan\Alexa\IntentRegistry;
use Weysan\Alexa\Intents\IntentsInterface;
use Weysan\Alexa\ValidateRequest;

class ValidateRequestTest extends TestCase
{
    protected $registered_intents = [];

    public function tearDown()
    {
        foreach ($this->registered_intents as $intentName) {
            IntentRegistry::unregisterIntentHandler($intentName);
        }
        $this->registered_intents = [];
    }

    public function testGoodAppIdAndGoodIntent()
    {
        $validator = new ValidateRequest("fakeappId");
        $this->registerMockIntent("GetJoke");
        $this->assertTrue(
            $validator->validateRequest($this->getAlexaIncomingInstance())
        );
    }

    public function testGoodAppIdAndBadIntent()
    {
        $validator = new ValidateRequest("fakeappId");
        $this->registerMockIntent("GetBadJoke");
        $this->assertFalse(
            $validator->validateRequest($this->getAlexaIncomingInstance())
        );
    }

    public function testBadAppIdAndGoodIntent()
    {
        $validator = new ValidateRequest("badAppId");
        $this->registerMockIntent("GetJoke");
        $this->assertFalse(
            $validator->validateRequest($this->getAlexaIncomingInstance())
        );
    }

    /**
     * @return AlexaIncomingRequest
     */
    protected function getAlexaIncomingInstance()
    {
        $body = file_get_contents(__DIR__ . '/incoming.json');
        $psr7Factory = new DiactorosFactory();
        $request = Request::create('/', 'POST', array(), array(), array(), array(), $body);
        $psr_request = $psr7Factory->createRequest($request);
        return new AlexaIncomingRequest($psr_request);
    }

    /**
     * @param string $intentName
     * @return bool
     */
    protected function registerMockIntent($intentName)
    {
        $this->registered_intents[] = $intentName;
        $intentMock = \Mockery::mock(IntentsInterface::class);
        IntentRegistry::registerIntentHandler($intentName, $intentMock);
        return true;
    }
}
