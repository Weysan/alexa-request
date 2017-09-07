# Alexa Requests Handler

[![Build Status](https://travis-ci.org/Weysan/alexa-request.svg?branch=master)](https://travis-ci.org/Weysan/alexa-request)
[![Coverage Status](https://coveralls.io/repos/github/Weysan/alexa-request/badge.svg?branch=master)](https://coveralls.io/github/Weysan/alexa-request?branch=master)

Small PHP Library in order to handle incoming and outgoing requests for
Amazon's Alexa applications in PHP.

## Installation
~~~
composer require weysan/alexa-request
~~~

## How to use it

The library is now compatible PSR-7. If you use HttpFoundation, you will need to use
the library `zendframework/zend-diactoros` to convert `Request` in `ServerRequestInterface` class.

see the documentation here : http://symfony.com/blog/psr-7-support-in-symfony-is-here

First, you have to create an Intent class which implement `Weysan\Alexa\Intents\IntentsInterface`.
You need to create a method `getResponseObject` which is returning a `Weysan\Alexa\Response\Response` instance.
You also need to create a method `getSessionAttributes` which is returning a `Weysan\Alexa\Response\SessionAttributes` instance.

For example :

~~~
namespace My\App;

use Weysan\Alexa\Intents\IntentsInterface;
use Weysan\Alexa\Response\Response;
use Weysan\Alexa\Response\SessionAttributes;

class Joke implements IntentsInterface
{
    /**
     * @return Response
     */
    public function getResponseObject()
    {
        $response = new Response();
        $response->addOutput()
            ->setType(OutputSpeech::TYPE_PLAIN_TEXT)
            ->setOutput("Here we go! This is a super Joke...");

        return $response;
    }
    
    /**
     * @return SessionAttributes
     */
    public function getSessionAttributes()
    {
        $sessionAttribute = new SessionAttributes();
        $sessionAttribute->addAttribute("my_key", "my_value");
        return $sessionAttribute;
    }
}
~~~

**Note** : If your Intent needs to access to Slots parameters or sessionAttributes, just add the trait `Weysan\Alexa\Helper\AlexaIncomingRequestAwareTrait`
in your class, you will have access to the current instance of `AlexaIncomingRequest`

After, Register your intent into `Weysan\Alexa\IntentRegistry`

~~~
use Weysan\Alexa\IntentRegistry;
use My\App\Joke;

IntentRegistry::registerIntentHandler("GetJoke", new Joke());
~~~
**Warning** : The name of the intent (here `GetJoke` needs to be the same name as you registered in Amazon console).

Create your endpoint using `AlexaIncomingRequest` and `AlexaOutgoingGenerator` :

~~~
$alexaIncoming = new AlexaIncomingRequest($request);
$alexaOutgoing = new AlexaOutgoingGenerator($alexaIncoming);
print json_encode($alexaOutgoing->getResponse());
~~~

## Validate the request

You can easily validate the requests from Alexa by Using `Weysan\Alexa\ValidateRequest` :

~~~
use Weysan\Alexa\ValidateRequest;

$validator = new ValidateRequest("appIdFromAmazon");

if ($validator->validateRequest($alexaIncomingRequest)) {
    //do what you want
}
~~~

The validator will check Alexa is requesting an existing Intent, and if your local appId is the same sent by Alexa.