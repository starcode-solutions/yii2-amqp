<?php

namespace starcode\amqp\helpers;

use starcode\amqp\Exchange;

class ExchangeBuilder
{
    protected $options = [];

    /**
     * @param array $options
     * @return static
     */
    public static function config($options = [])
    {
        $builder = new static();
        $builder->options = $options;
        return $builder;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return Exchange
     */
    public function build()
    {
        return new Exchange($this->options);
    }

    /**
     * @param string $connectionComponentId
     * @return $this
     */
    public function connectionComponentId($connectionComponentId = 'amqp')
    {
        $this->options['connectionComponentId'] = $connectionComponentId;
        return $this;
    }

    /**
     * @param null $channelId
     * @return $this
     */
    public function channelId($channelId = null)
    {
        $this->options['channelId'] = $channelId;
        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function name($name)
    {
        $this->options['name'] = $name;
        return $this;
    }

    /**
     * @param string $type Exchange type (direct, topic, headers, fanout)
     * @return $this
     */
    public function type($type)
    {
        $this->options['type'] = $type;
        return $this;
    }

    /**
     * @param bool $passive
     * @return $this
     */
    public function passive($passive = true)
    {
        $this->options['passive'] = $passive;
        return $this;
    }

    /**
     * @param bool $durable
     * @return $this
     */
    public function durable($durable = true)
    {
        $this->options['durable'] = $durable;
        return $this;
    }

    /**
     * @param bool $auto_delete
     * @return $this
     */
    public function auto_delete($auto_delete = true)
    {
        $this->options['auto_delete'] = $auto_delete;
        return $this;
    }

    /**
     * @param bool $internal
     * @return $this
     */
    public function internal($internal = true)
    {
        $this->options['internal'] = $internal;
        return $this;
    }

    /**
     * @param bool $nowait
     * @return $this
     */
    public function nowait($nowait = true)
    {
        $this->options['nowait'] = $nowait;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function arguments($arguments)
    {
        $this->options['arguments'] = $arguments;
        return $this;
    }

    /**
     * @param $ticket
     * @return $this
     */
    public function ticket($ticket)
    {
        $this->options['ticket'] = $ticket;
        return $this;
    }
}