<?php
/**
 * Created by PhpStorm.
 * User: starcode
 * Date: 03.12.15
 * Time: 15:46
 */

namespace starcode\amqp;


use yii\base\Object;

class Exchange extends Object
{
    use CommonTrait;

    const TYPE_TOPIC = 'topic';
    const TYPE_DIRECT = 'direct';
    const TYPE_HEADERS = 'headers';
    const TYPE_FANOUT = 'fanout';

    public $connectionComponentId = 'amqp';
    public $channelId;
    /** @var  mixed|null */
    protected $_exchange;

    /** @var string Name of exchange */
    public $name;

    /** @var  string Exchange type (direct, topic, headers, fanout) */
    public $type = 'fanout';

    public $passive = false;
    public $durable = false;
    public $auto_delete = true;
    public $internal = false;
    public $nowait = false;
    public $arguments = null;
    public $ticket = null;

    public function init()
    {
        parent::init();
        $channel = $this->getChannel();
        $this->_exchange = $channel->exchange_declare(
            $this->name,
            $this->type,
            $this->passive,
            $this->durable,
            $this->auto_delete,
            $this->internal,
            $this->nowait,
            $this->arguments,
            $this->ticket
        );
    }

    public function getExchange(){
        return $this->_exchange;
    }

    /**
     * Publish message to exchange
     * @param Message $message
     * @param $options
     */
    public function publish(Message $message, array $options = [])
    {
        $defaultOptions = [
            'routing_key' => '',
            'mandatory' => false,
            'immediate' => false,
            'ticket' => null
        ];
        $options = array_merge($defaultOptions, $options);
        $this->getChannel()->basic_publish(
            $message,
            $this->name,
            $options['routing_key'],
            $options['mandatory'],
            $options['immediate'],
            $options['ticket']);
    }

    /**
     * Create new queue and bind it to exchange
     * @param string $name
     * @param array $bindOptions Options passed to queue_bind()
     * @return Queue
     */
    public function getQueue($name = '', array $bindOptions = [])
    {
        $queue = new Queue(['name' => $name]);
        $this->bind($queue, $bindOptions);
        return $queue;
    }

    /**
     * Bind queue to exchange
     * @param Queue $queue
     * @param array $bindOptions Options passed to queue_bind()
     * @return mixed|null
     */
    public function bind(Queue $queue, array $bindOptions = [])
    {
        $defaultOptions = [
            'routing_key' => '',
            'nowait'      => false,
            'arguments'   => null,
            'ticket'      => null
        ];
        $options = array_merge($defaultOptions, $bindOptions);

        return $this->getChannel()->queue_bind($queue->name, $this->name, $options['routing_key'], $options['nowait'], $options['arguments'], $options['ticket']);
    }
}