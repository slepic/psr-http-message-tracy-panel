<?php

namespace Slepic\Tests\Psr\Http\TransferLog;

use GuzzleHttp\MessageFormatter;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slepic\Psr\Http\TransferLog\GuzzleMessageFormatter;
use Slepic\Psr\Http\TransferLog\FormatterInterface;

class GuzzleMessageFormatterTest extends TestCase
{
    /**
     * @var MessageFormatter|\PHPUnit_Framework_MockObject_MockObject
     */
    private $guzzle;

    /**
     * @var FormatterInterface
     */
    private $formatter;

    /**
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->guzzle = $this->createMock(MessageFormatter::class);
        $this->formatter = new GuzzleMessageFormatter($this->guzzle);
    }

    /**
     * Test that the formatter implements FormatterInterface
     *
     * @return void
     */
    public function testImplements()
    {
        $this->assertInstanceOf(FormatterInterface::class, $this->formatter);
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface|null $response
     * @param \Exception|null $exception
     * @dataProvider provideTransferLogs
     */
    public function testFormat(RequestInterface $request, ResponseInterface $response = null, \Exception $exception = null)
    {
        $expectedOutput = \md5(\time());
        $this->guzzle->expects($this->once())
            ->method('format')
            ->with($request, $response, $exception)
            ->willReturn($expectedOutput);

        $output = $this->formatter->formatTransferLog($request, $response, $exception);
        $this->assertSame($expectedOutput, $output);
    }



    /**
     * @return array
     */
    public function provideTransferLogs()
    {
        return [
            [
                $this->createMock(RequestInterface::class),
                null,
                null,
            ],
            [
                $this->createMock(RequestInterface::class),
                $this->createMock(ResponseInterface::class),
                null,
            ],
            [
                $this->createMock(RequestInterface::class),
                null,
                new \Exception(),
            ],
            [
                $this->createMock(RequestInterface::class),
                $this->createMock(ResponseInterface::class),
                new \Exception(),
            ],
        ];
    }
}
