<?php

namespace starcode\amqp\components;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use starcode\amqp\Queue;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class Connection extends Component
{
    public $host;
    public $port;
    public $user;
    public $password;
    public $connectionOptions = [];
    public $queuesConfig = [];

    /**
     * @var AMQPStreamConnection
     */
    private $_amqpStreamConnection;

    /**
     * @var AMQPChannel
     */
    private $_amqpChannel;

    /**
     * @var AMQPChannel[]
     */
    private $_amqpChannelArray = [];

    /**
     * @var Queue[]
     */
    private $_queues = [];

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

    /**
     * @param null $channelId
     * @return AMQPChannel
     */
    public function getAmqpChannel($channelId = null)
    {
        if ($channelId == null) {
            if (!($this->_amqpChannel instanceof AMQPChannel)) {
                $this->_amqpChannel = $this->getAmqpStreamConnection()
                    ->channel($channelId);
            }
            return $this->_amqpChannel;
        } else {
            if (!isset($this->_amqpChannelArray[$channelId])
                || !($this->_amqpChannelArray[$channelId] instanceof AMQPChannel))
            {
                $this->_amqpChannelArray[$channelId] = $this->getAmqpStreamConnection()
                    ->channel($channelId);
            }
            return $this->_amqpChannelArray[$channelId];
        }
    }

    /**
     * Get configured queue by id.
     *
     * @param $id
     * @return Queue
     * @throws InvalidConfigException
     */
    public function getQueue($id)
    {
        if (!isset($this->_queues[$id]) || !($this->_queues[$id] instanceof Queue)) {
            if (!isset($this->queuesConfig[$id])) {
                throw new InvalidConfigException("AMQP queue {$id} not configured.");
            }

            $config = $this->queuesConfig[$id];
            if (!isset($config['class'])) {
                $config['class'] = Queue::className();
            }
            $this->_queues[$id] = Yii::createObject($config);
        }

        return $this->_queues[$id];
    }

    public function wait($allowed_methods = null, $non_blocking = false, $timeout = 0)
    {
        $channel = $this->getAmqpChannel();
        while (count($channel->callbacks)) {
            $channel->wait($allowed_methods, $non_blocking, $timeout);
        }
    }
}