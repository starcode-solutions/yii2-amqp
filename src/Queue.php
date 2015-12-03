<?php

namespace starcode\amqp;

use yii\base\Object;

class Queue extends Object
{
    use CommonTrait;

    public $connectionComponentId = 'amqp';
    public $channelId;
    public $name = '';
    public $passive = false;
    public $durable = false;
    public $exclusive = false;
    public $auto_delete = true;
    public $nowait = false;
    public $arguments = null;
    public $ticket = null;

    public function init()
    {
        parent::init();

        $channel = $this->getChannel();
        list($temporaryQueue, , ) = $channel->queue_declare(
            $this->name,
            $this->passive,
            $this->durable,
            $this->exclusive,
            $this->auto_delete,
            $this->nowait,
            $this->arguments,
            $this->ticket
        );
        if (empty($this->name)) {
            $this->name = $temporaryQueue;
        }
    }

    /**
     * Publishes a message.
     *
     * @param Message $msg
     * @param null $options
     * @throws \yii\base\Exception
     */
    public function publish(Message $msg, $options = null)
    {
        if (!is_array($options)) {
            $options = [];
        }

        $defaultOptions = [
            'exchange' => '',
            'routing_key' => $this->name,
            'mandatory' => false,
            'immediate' => false,
            'ticket' => null,
        ];

        $options = array_merge($defaultOptions, $options);

        $channel = $this->getChannel();
        $channel->basic_publish($msg,
            $options['exchange'],
            $options['routing_key'],
            $options['mandatory'],
            $options['immediate'],
            $options['ticket']);
    }

    /**
     * Starts a queue consumer.
     *
     * @param null $options
     * @return mixed|string
     * @throws \yii\base\Exception
     */
    public function consume($options = null)
    {
        if (!is_array($options)) {
            $options = [];
        }

        $defaultOptions = [
            'queue' => $this->name,
            'consumer_tag' => '',
            'no_local' => false,
            'no_ack' => false,
            'exclusive' => false,
            'nowait' => false,
            'callback' => null,
            'ticket' => null,
            'arguments' => [],
        ];

        $options = array_merge($defaultOptions, $options);

        $channel = $this->getChannel();
        $consumer_tag = $channel->basic_consume($options['queue'],
            $options['consumer_tag'],
            $options['no_local'],
            $options['no_ack'],
            $options['exclusive'],
            $options['nowait'],
            $options['callback'],
            $options['ticket'],
            $options['arguments']);

        return $consumer_tag;
    }
}