<?php

namespace memclutter\amqp\components;

use PhpAmqpLib\Channel\AMQPChannel;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

abstract class BaseComponent extends Component
{
    const EXCHANGE_TYPE_FANOUT = 'fanout';
    const EXCHANGE_TYPE_DIRECT = 'direct';
    const EXCHANGE_TYPE_TOPIC = 'topic';

    /** @var Amqp */
    public $amqp;
    public $exchange = 'exchange';
    public $exchangeType = self::EXCHANGE_TYPE_TOPIC;
    public $exchangeOptions = [];
    /** @var AMQPChannel */
    public $channel;
    public $channelId;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->amqp == null) {
            $this->amqp = Yii::$app->get('amqp');
        }

        $exchangeTypes = [
            self::EXCHANGE_TYPE_DIRECT,
            self::EXCHANGE_TYPE_TOPIC,
            self::EXCHANGE_TYPE_FANOUT,
        ];

        if (!in_array($this->exchangeType, $exchangeTypes)) {
            throw new InvalidConfigException("Invalid exchange type {$this->exchangeType}");
        }

        if ($this->channel == null) {
            $this->channel = $this->amqp->getConnection()->channel($this->channelId);
        }

        $this->channel->exchange_declare($this->exchange, $this->exchangeType,
            isset($this->exchangeOptions['passive']) ? $this->exchangeOptions['passive'] : false,
            isset($this->exchangeOptions['durable']) ? $this->exchangeOptions['durable'] : false,
            isset($this->exchangeOptions['autoDelete']) ? $this->exchangeOptions['autoDelete'] : false);
    }
}