#Alexa Requests Handler

[![Build Status](https://travis-ci.org/Weysan/alexa-request.svg?branch=master)](https://travis-ci.org/Weysan/alexa-request)
[![Coverage Status](https://coveralls.io/repos/github/Weysan/alexa-request/badge.svg?branch=master)](https://coveralls.io/github/Weysan/alexa-request?branch=master)

Small PHP Library in order to handle incoming and outgoing requests for
Amazon's Alexa applications in PHP.

## Installation
~~~
composer require weysan/alexa-request
~~~

## How to use it

I use the component `symfony/http-foundation` to handle HTTP requests.

First, you have to create an Intent class which implement `Weysan\Alexa\Intents\IntentsInterface`.
You need to create a method `getResponseObject` which is returning a `Weysan\Alexa\Response\OutputSpeech` instance.
You also need to create a method `getSessionAttributes` which is returning a `Weysan\Alexa\Response\SessionAttributes` instance.

For example :

~~~
namespace My\App;

use Weysan\Alexa\Intents\IntentsInterface;
use Weysan\Alexa\Response\OutputSpeech;
use Weysan\Alexa\Response\SessionAttributes;

class Joke implements IntentsInterface
{
    /**
     * @return OutputSpeech
     */
    public function getResponseObject()
    {
        $outputSpeech = new OutputSpeech();
        $outputSpeech->setType(OutputSpeech::TYPE_PLAIN_TEXT);
        $outputSpeech->setOutput("Here we go! This is a super Joke...");

        return $outputSpeech;
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