<?php

namespace memclutter\amqp;

use memclutter\amqp\components\Producer;
use PhpAmqpLib\Message\AMQPMessage;

trait AmqpProducerTrait
{
    public function amqpPublishText($body, $routingKey = '', $producerOptions = [])
    {
        $message = new AMQPMessage($body, ['content_type' => 'text/plain']);
        $producer = new Producer($producerOptions);
        $producer->publish($message, $routingKey);
    }

    public function amqpPublishJson(array $body, $routingKey = '', $producerOptions = [])
    {
        $message = new AMQPMessage($body, ['content_type' => 'application/json']);
        $producer = new Producer($producerOptions);
        $producer->publish($message, $routingKey);
    }
}