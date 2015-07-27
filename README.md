# yii2-amqp

[![Latest Stable Version](https://poser.pugx.org/starcode-krasnodar/yii2-amqp/v/stable)](https://packagist.org/packages/starcode-krasnodar/yii2-amqp) [![Total Downloads](https://poser.pugx.org/starcode-krasnodar/yii2-amqp/downloads)](https://packagist.org/packages/starcode-krasnodar/yii2-amqp) [![Latest Unstable Version](https://poser.pugx.org/starcode-krasnodar/yii2-amqp/v/unstable)](https://packagist.org/packages/starcode-krasnodar/yii2-amqp) [![License](https://poser.pugx.org/starcode-krasnodar/yii2-amqp/license)](https://packagist.org/packages/starcode-krasnodar/yii2-amqp)

Extension Yii2 for working with AMQP protocol
# installation
Via composer

    composer require "starcode/yii2-amqp"
    
or add composer.json

```json
{
    "require": {
        "starcode/yii2-amqp": "dev-master"
    }
}
```

# configuration
Create amqp component config

```php
[
    'components' => [
        'amqp' => [
            'class' => 'starcode\amqp\components\Amqp',
            'host' => 'localhost',
            'user' => 'guest',
            'pass' => 'guest',
            'vhost' => '/',
        ],
        
        'exchanges' => [
            'exchange' => [
                'type' => 'topic',
                'options' => ['durable' => true],
            ],
            'alternative' => [
                'type' => 'fanout',
                'options' => ['autoDelete' => false],
            ],
        ],
        
        'defaultExchange' => 'exchange',
    ],
];
```

# usage
Publish message.

```php
// create producer for work with default exchange
$producer = new starcode\amqp\components\Producer();
$message = 'my message';
$routingKey = 'my.routing.key';

// publish message
$producer->publish($message, $routingKey);
```

Listen messages

```php
// consumer for default exchange
$consumer = new starcode\amqp\components\Consumer();
$callback = function($message) {
    echo $message->body;
};
$routingKey = 'my.routing.key';

// consume message 
$consumer->consume($callback, $routingKey);
//$consumer->consume($callbackOther, 'other.route.key');
$consumer->wait();
```