<?php

namespace starcode\amqp;

use starcode\amqp\components\Producer;
use PhpAmqpLib\Message\AMQPMessage;

trait AmqpProducerTrait
{
    public function amqpPublishText($body, $routingKey = '', $messageProperties = null, $producerOptions = [])
    {
        $message = new AMQPMessage($body, ['content_type' => 'text/plain']);
        $producer = new Producer($producerOptions);
        $producer->publish($message, $routingKey, $messageProperties);
    }

    public function amqpPublishJson(array $body, $routingKey = '', $messageProperties = null, $producerOptions = [])
    {
        $message = new AMQPMessage($body, ['content_type' => 'application/json']);
        $producer = new Producer($producerOptions);
        $producer->publish($message, $routingKey, $messageProperties);
    }
}