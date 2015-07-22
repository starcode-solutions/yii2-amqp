<?php

namespace memclutter\amqp\components;

use PhpAmqpLib\Channel\AMQPChannel;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

abstract class BaseComponent extends Component
{
    const EXCHANGE_TYPE_FANOUT = 'fanout';
    const EXCHANGE_TYPE_DIRECT = 'direct';
    const EXCHANGE_TYPE_TOPIC = 'topic';

    /** @var Amqp */
    public $amqp;
    public $exchange = 'exchange';
    public $exchangeType;
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

        if (isset($this->amqp->exchanges[$this->exchange])) {
            if (empty($this->exchangeType)) {
                $this->exchangeType = isset($this->amqp->exchanges[$this->exchange]['type'])
                    ? $this->amqp->exchanges[$this->exchange]['type'] : self::EXCHANGE_TYPE_TOPIC;
            }

            if (isset($this->amqp->exchanges[$this->exchange]['options'])) {
                $this->exchangeOptions = ArrayHelper::merge($this->amqp->exchanges[$this->exchange]['options'],
                    $this->exchangeOptions);
            }
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