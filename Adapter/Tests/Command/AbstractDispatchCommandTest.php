<?php
/**
 * @LICENSE_TEXT
 */

namespace EventBand\Adapter\Symfony\Tests\Command;

use EventBand\Adapter\Symfony\Command\AbstractDispatchCommand;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Class AbstractDispatchCommandTest
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class AbstractDispatchCommandTest extends TestCase
{
    /**
     * @var AbstractDispatchCommand|\PHPUnit_Framework_MockObject_MockObject
     */
    private $command;

    protected function setUp()
    {
        $this->command = $this->getMockBuilder('EventBand\Adapter\Symfony\Command\AbstractDispatchCommand')
            ->setMethods([
                'getDispatcher',
                'getConsumer',
                'getBandName',
                'getDefaultTimeout'
            ])
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    /**
     * @test if band name is not set argument is added
     */
    public function unsetBandName()
    {
        $this->command->__construct('dispatch');

        $this->assertTrue($this->command->getDefinition()->hasArgument('band'));
    }

    /**
     * @test if band named is set no argument is added
     */
    public function setBandName()
    {
        $this->command
            ->expects($this->any())
            ->method('getBandName')
            ->will($this->returnValue('name'))
        ;

        $this->command->__construct('dispatch');

        $this->assertFalse($this->command->getDefinition()->hasArgument('band'));
    }

    /**
     * @test override getTimeout set default option value
     */
    public function setTimeout()
    {
        $this->command
            ->expects($this->any())
            ->method('getDefaultTimeout')
            ->will($this->returnValue(10))
        ;

        $this->command->__construct('dispatch');

        $this->assertEquals(10, $this->command->getDefinition()->getOption('timeout')->getDefault());
    }
}
