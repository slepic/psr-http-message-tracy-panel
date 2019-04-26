<?php

namespace Slepic\Tests\Psr\Http\TransferLog;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slepic\Psr\Http\TransferLog\ArrayStorage;
use Slepic\Psr\Http\TransferLog\TransferLoggerInterface;
use Slepic\Psr\Http\TransferLog\LogProviderInterface;

class ArrayStorageTest extends TestCase
{
    /**
     * @var ArrayStorage
     */
    private $storage;

    /**
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->storage = new ArrayStorage();
    }


    /**
     * Test that the storage implements TransferLoggerInterface and TransferLogProviderInterface
     *
     * @return void
     */
    public function testImplements()
    {
        $this->assertInstanceOf(TransferLoggerInterface::class, $this->storage);
        $this->assertInstanceOf(LogProviderInterface::class, $this->storage);
    }

    /**
     * Test individual transfer logs
     *
     * @param RequestInterface $request
     * @param ResponseInterface|null $response
     * @param \Exception|null $exception
     * @dataProvider provideTransferLogs
     */
    public function testLog(RequestInterface $request, ResponseInterface $response = null, \Exception $exception = null)
    {
        $this->storage->logHttpTransfer($request, $response, $exception);

        $count = $this->storage->countHttpTransferLogs();
        $logs = $this->storage->getHttpTransferLogs();

        //check count is correct
        $this->assertSame(1, $count);

        //check returns array of logs
        $this->assertInternalType('array', $logs);

        //check size of array is same as count
        $this->assertSame($count, \count($logs));

        //check the logs contain previously passed data
        $this->assertContains(
            [
                'request' => $request,
                'response' => $response,
                'exception' => $exception,
            ],
            $logs
        );
    }

    /**
     * Test not a single log from a bulk of logs is lost and the logs are in the order in which they were logged.
     *
     * @return void
     */
    public function testAllLogs()
    {
        $data = $this->provideTransferLogs();
        foreach ($data as $log) {
            $this->storage->logHttpTransfer($log[0], $log[1], $log[2]);
        }
        $count = $this->storage->countHttpTransferLogs();
        $logs = $this->storage->getHttpTransferLogs();

        //check count is correct
        $this->assertSame(\count($data), $count);

        //check returns array of logs
        $this->assertInternalType('array', $logs);

        //check size of array is same as count
        $this->assertSame($count, \count($logs));

        //check the logs contain previously passed data in correct order
        $this->assertSame(\array_map(function ($item) {
            return [
                'request' => $item[0],
                'response' => $item[1],
                'exception' => $item[2],
            ];
        }, $data), $logs);
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
