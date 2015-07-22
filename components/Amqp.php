<?php

namespace memclutter\amqp\components;

use PhpAmqpLib\Connection\AMQPConnection;
use yii\base\Component;

class Amqp extends Component
{
    public $host = '127.0.0.1';
    public $port = 5672;
    public $user;
    public $pass;
    public $vhost = '/';
    public $exchanges = [];
    public $defaultExchange = 'exchange';
    protected $_connection;

    public function getConnection()
    {
        if ($this->_connection == null) {
            $this->_connection = new AMQPConnection($this->host, $this->port, $this->user, $this->pass, $this->vhost);
        }
        return $this->_connection;
    }
}