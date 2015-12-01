# yii2-amqp

[![Latest Stable Version](https://poser.pugx.org/starcode-krasnodar/yii2-amqp/v/stable)](https://packagist.org/packages/starcode-krasnodar/yii2-amqp) [![Total Downloads](https://poser.pugx.org/starcode-krasnodar/yii2-amqp/downloads)](https://packagist.org/packages/starcode-krasnodar/yii2-amqp) [![Latest Unstable Version](https://poser.pugx.org/starcode-krasnodar/yii2-amqp/v/unstable)](https://packagist.org/packages/starcode-krasnodar/yii2-amqp) [![License](https://poser.pugx.org/starcode-krasnodar/yii2-amqp/license)](https://packagist.org/packages/starcode-krasnodar/yii2-amqp)

Extension Yii2 for working with AMQP protocol
# installation
Via composer

    composer require "starcode/yii2-amqp:2.*"
    
or add composer.json

```json
{
    "require": {
        "starcode/yii2-amqp": "2.*"
    }
}
```

# configuration
Create amqp component config

```php
[
    'components' => [
        'amqp' => [
            'class' => 'starcode\amqp\components\Connection',
            'host' => 'localhost',
            'user' => 'guest',
            'password' => 'guest',
            'connectionOptions' => [
                'vhost' => '/',
            ],
            
            'queuesConfig' => [
                'email' => [
                    'queue' => 'email',
                    'durable' => true,
                    'auto_delete' => false,
                ],
                'logs' => [
                    'queue' => 'logs',
                    'durable' => true,
                    'auto_delete' => false,
                ],
            ],
        ],
    ],
];
```

# usage
Publish message.

```php
// get queue object
$queue = Yii::$app->get('amqp')->getQueue('email');

// create message object
$message = new Message('my message', ['delivery_mode' => 2]);

// publish message
$queue->publish($message);
```

Listen messages

```php
// get queue object
$queue = Yii::$app->get('amqp')->getQueue('email');

// callback listener function
$callback = function($message) {
    echo $message->body;
    
    // acknowledge message
    $channel = $msg->delivery_info['channel'];
    $channel->basic_ack($msg->delivery_info['delivery_tag']);
};

$queue->consume([
    'callback' => $callback,
]);

$channel = $queue->getChannel();
while (count($channel->callbacks)) {
    $channel->wait();
}
```