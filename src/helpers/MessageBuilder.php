<?php

namespace starcode\amqp\helpers;

use starcode\amqp\Message;

class MessageBuilder
{
    protected $body = '';
    protected $options = [];

    /**
     * @param string $body
     * @param array $options
     * @return static
     */
    public static function config($body = '', $options = [])
    {
        $builder = new static();
        $builder->body = $body;
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
     * @return Message
     */
    public function build()
    {
        return new Message($this->body, $this->options);
    }

    /**
     * @param $body
     * @return $this
     */
    public function body($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @param $content_type
     * @return $this
     */
    public function content_type($content_type)
    {
        $this->options['content_type'] = $content_type;
        return $this;
    }

    /**
     * @param $content_encoding
     * @return $this
     */
    public function content_encoding($content_encoding)
    {
        $this->options['content_encoding'] = $content_encoding;
        return $this;
    }

    /**
     * @param $application_headers
     * @return $this
     */
    public function application_headers($application_headers)
    {
        $this->options['application_headers'] = $application_headers;
        return $this;
    }

    /**
     * @param $delivery_mode
     * @return $this
     */
    public function delivery_mode($delivery_mode)
    {
        $this->options['delivery_mode'] = $delivery_mode;
        return $this;
    }

    /**
     * @param $priority
     * @return $this
     */
    public function priority($priority)
    {
        $this->options['priority'] = $priority;
        return $this;
    }

    /**
     * @param $correlation_id
     * @return $this
     */
    public function correlation_id($correlation_id)
    {
        $this->options['correlation_id'] = $correlation_id;
        return $this;
    }

    /**
     * @param $reply_to
     * @return $this
     */
    public function reply_to($reply_to)
    {
        $this->options['reply_to'] = $reply_to;
        return $this;
    }

    /**
     * @param $expiration
     * @return $this
     */
    public function expiration($expiration)
    {
        $this->options['expiration'] = $expiration;
        return $this;
    }

    /**
     * @param $message_id
     * @return $this
     */
    public function message_id($message_id)
    {
        $this->options['message_id'] = $message_id;
        return $this;
    }

    /**
     * @param $timestamp
     * @return $this
     */
    public function timestamp($timestamp)
    {
        $this->options['timestamp'] = $timestamp;
        return $this;
    }

    /**
     * @param $type
     * @return $this
     */
    public function type($type)
    {
        $this->options['type'] = $type;
        return $this;
    }

    /**
     * @param $user_id
     * @return $this
     */
    public function user_id($user_id)
    {
        $this->options['user_id'] = $user_id;
        return $this;
    }

    /**
     * @param $app_id
     * @return $this
     */
    public function app_id($app_id)
    {
        $this->options['app_id'] = $app_id;
        return $this;
    }

    /**
     * @param $cluster_id
     * @return $this
     */
    public function cluster_id($cluster_id)
    {
        $this->options['cluster_id'] = $cluster_id;
        return $this;
    }
}