# yii2-amqp
Extension Yii2 for working with AMQP protocol
# installation
Via composer

    composer require "memclutter/yii2-amqp"
    
or add composer.json

```json
{
    "require": {
        "memclutter/yii2-amqp": "*"
    }
}
```

# configuration
Create amqp component config

```php
[
    'components' => [
        'amqp' => [
            'class' => 'memclutter\amqp\components\Amqp',
            'host' => 'localhost',
            'user' => 'guest',
            'pass' => 'guest',
            'vhost' => '/',
        ],
    ],
];
```

# usage
Create producer.

```php
$producer = new memclutter\amqp\components\Producer([
    'exchange' => 'exchange-name',
    'exchangeType' => 'topic',
    'exchangeOptions' => [
        'durable' => true,
    ],
]);
$message = 'my message';
$routingKey = 'my.routing.key';
$producer->publish($message, $routingKey);
```

Listen messages using consumer component

```php
$consumer = new memclutter\amqp\components\Consumer([
    'exchange' => 'exchange-name',
    'exchangeType' => 'topic',
        'exchangeOptions' => [
            'durable' => true,
        ],
    ],
]);
$routingKey = 'my.routing.key';
$callback = function($message) {
    echo $message->body;
};
$consumer->consume($routingKey, $callback);
$consumer->wait();
```