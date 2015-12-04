<?php

namespace starcode\amqp;

use PhpAmqpLib\Message\AMQPMessage;

class Message extends AMQPMessage
{
    /**
     * Set persist mode (delivery_mode = 2)
     * @return $this
     */
    public function persist(){
        $this->set('delivery_mode', 2);
        return $this;
    }
}