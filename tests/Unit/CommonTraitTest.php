<?php

namespace starcode\amqp\tests\Unit;

use PhpAmqpLib\Channel\AMQPChannel;
use starcode\amqp\CommonTrait;
use starcode\amqp\components\Connection;
use yii\base\Component;
use yii\web\Application;

class CommonTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $appMock;

    /**
     * @var CommonTrait
     */
    private $trait;

    protected function setUp()
    {
        parent::setUp();

        $this->appMock = $this->getMockBuilder(Application::class)->disableOriginalConstructor()->getMock();
        $this->trait = $this->getMockForTrait(CommonTrait::class);

        \Yii::$app = $this->appMock;
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->appMock = null;
        $this->trait = null;
    }

    /**
     * @expectedException \yii\base\InvalidParamException
     * @expectedExceptionMessage For get amqp connection, please set connectionComponentId
     */
    public function testGetConnectionThrowingException()
    {
        $this->appMock->expects($this->never())->method('get');
        $this->trait->getConnection();
    }

    public function testGetConnection()
    {
        $componentId = 'my-test';

        $componentMock = $this->getMockBuilder(Component::class)->disableOriginalConstructor()->getMock();
        $this->appMock->expects($this->once())->method('get')->with($componentId)->willReturn($componentMock);
        $this->trait->connectionComponentId = $componentId;

        $result = $this->trait->getConnection();

        $this->assertSame($componentMock, $result);
    }

    /**
     * @expectedException \yii\base\InvalidParamException
     * @expectedExceptionMessage For get amqp channel, please set channelId property
     */
    public function testGetChannelException()
    {
        $this->appMock->expects($this->never())->method('get');
        $this->trait->getChannel();
    }

    public function testGetChannel()
    {
        $componentId = 'my-component';
        $channelId = 'my-channel';

        $channelMock = $this->getMockBuilder(AMQPChannel::class)->disableOriginalConstructor()->getMock();

        $componentMock = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
        $componentMock->expects($this->once())->method('getAmqpChannel')->with($channelId)->willReturn($channelMock);

        $this->appMock->expects($this->once())->method('get')->with($componentId)->willReturn($componentMock);
        $this->trait->connectionComponentId = $componentId;
        $this->trait->channelId = $channelId;

        $result = $this->trait->getChannel();

        $this->assertSame($channelMock, $result);
    }


}