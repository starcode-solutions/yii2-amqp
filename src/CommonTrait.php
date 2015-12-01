<?php

namespace starcode\amqp;

use PhpAmqpLib\Channel\AMQPChannel;
use starcode\amqp\components\Connection;
use Yii;
use yii\base\InvalidParamException;

trait CommonTrait
{
    /**
     * @var Connection
     */
    private $_connection;

    /**
     * @var AMQPChannel
     */
    private $_channel;

    /**
     * @return null|object|Connection
     * @throws \yii\base\InvalidConfigException
     */
    public function getConnection()
    {
        if (!($this->_connection instanceof Connection)) {
            if (!property_exists($this, 'connectionComponentId')) {
                throw new InvalidParamException('For get amqp connection, please set connectionComponentId');
            }

            $this->_connection = Yii::$app->get($this->{'connectionComponentId'});
        }
        return $this->_connection;
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel()
    {
        if (!($this->_channel instanceof AMQPChannel)) {
            if (!property_exists($this, 'channelId')) {
                throw new InvalidParamException('For get amqp channel, please set channelId property');
            }

            $this->_channel = $this->getConnection()
                ->getAmqpChannel($this->{'channelId'});
        }
        return $this->_channel;
    }
}