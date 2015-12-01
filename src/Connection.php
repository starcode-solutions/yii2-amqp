<?php

namespace starcode\amqp;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use yii\base\Component;

class Connection extends Component
{
    public $host;
    public $port;
    public $user;
    public $password;
    public $connectionOptions = [];

    /**
     * @var AMQPStreamConnection
     */
    private $_amqpStreamConnection;

    public function init()
    {
        parent::init();

        // todo: validate required params.

        if (!isset($this->connectionOptions['vhost'])) {
            $this->connectionOptions['vhost'] = '/';
        }

        if (!isset($this->connectionOptions['insist'])) {
            $this->connectionOptions['insist'] = false;
        }

        // todo: all connection options here
    }

    /**
     * @return AMQPStreamConnection
     */
    public function getAmqpStreamConnection()
    {
        if (!($this->_amqpStreamConnection instanceof AMQPStreamConnection)) {
            $this->_amqpStreamConnection = new AMQPStreamConnection(
                $this->host,
                $this->port,
                $this->user,
                $this->password,
                $this->connectionOptions['vhost'],
                $this->connectionOptions['insist']
            );
        }
        return $this->_amqpStreamConnection;
    }
}