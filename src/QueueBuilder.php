<?php

namespace starcode\amqp;

class QueueBuilder
{
    protected $options = [];

    /**
     * @return static
     */
    public static function config()
    {
        return new static();
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return Queue
     */
    public function build()
    {
        return new Queue($this->options);
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
     * @param string $name
     * @return $this
     */
    public function name($name = '')
    {
        $this->options['name'] = $name;
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
     * @param bool $exclusive
     * @return $this
     */
    public function exclusive($exclusive = true)
    {
        $this->options['exclusive'] = $exclusive;
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