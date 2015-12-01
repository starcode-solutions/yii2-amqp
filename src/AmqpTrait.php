<?php

namespace starcode\amqp;

use starcode\amqp\components\Connection;
use Yii;

trait AmqpTrait
{
    public $amqpConnectionComponentId = 'amqp';

    /**
     * @param $id
     * @return Queue
     */
    public function amqpGetQueue($id)
    {
        return $this->amqpGetConnection()
            ->getQueue($id);
    }

    /**
     * @return null|Connection
     * @throws \yii\base\InvalidConfigException
     */
    public function amqpGetConnection()
    {
        return Yii::$app->get($this->amqpConnectionComponentId);
    }
}