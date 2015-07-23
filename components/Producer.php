<?php

namespace starcode\amqp\components;

use PhpAmqpLib\Message\AMQPMessage;
use yii\helpers\Json;

/**
 * AMQP producer component.
 */
class Producer extends BaseComponent
{
    public function publish($message, $routingKey = '')
    {
        if (is_object($message) || is_array($message)) {
            $message = Json::encode($message);
        }
        $message = new AMQPMessage($message);
        $this->channel->basic_publish($message, $this->exchange, $routingKey);
    }
}