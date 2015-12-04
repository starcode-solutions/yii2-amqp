<?php
/**
 * Created by PhpStorm.
 * User: starcode
 * Date: 04.12.15
 * Time: 12:38
 */

namespace starcode\amqp\helpers;

/**
 * Class BindConfigBuilder
 * Helper to build bind config
 * @package starcode\amqp\helpers
 */
class BindConfigBuilder
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
     * @param string $queue Queue name
     * @return $this
     */
    public function queue($queue)
    {
        $this->options['queue'] = $queue;
        return $this;
    }

    /**
     * @param string $routing_key
     * @return $this
     */
    public function routing_key($routing_key)
    {
        $this->options['routing_key'] = $routing_key;
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

    public function ticket($ticket)
    {
        $this->options['ticket'] = $ticket;
        return $this;
    }
}