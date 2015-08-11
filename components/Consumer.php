<?php

namespace starcode\amqp\components;

use yii\helpers\ArrayHelper;

/**
 * AMQP consumer component.
 */
class Consumer extends BaseComponent
{
    public function consume($callback, $routingKey = '', $consumeOptions = [])
    {
        list($queueName, ,) = $this->channel->queue_declare("", false, false, true, false);
        $this->channel->queue_bind($queueName, $this->exchange, $routingKey);
        $options = ArrayHelper::merge([
            'consumerTag' => '',
            'noLocal' => false,
            'noAck' => false,
            'exclusive' => false,
            'noWait' => false,
        ], $consumeOptions);
        $this->channel->basic_consume($queueName,
            $options['consumerTag'],
            $options['noLocal'],
            $options['noAck'],
            $options['exclusive'],
            $options['noWait'], $callback);
    }

    public function wait()
    {
        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }
}