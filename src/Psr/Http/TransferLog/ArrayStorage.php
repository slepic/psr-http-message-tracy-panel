<?php

namespace Slepic\Psr\Http\TransferLog;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ArrayStorage
 * @package Slepic\Psr\Http\TransferLog
 *
 * This class implements both TransferLoggerInterface and TransferLogProviderInterface over a simple PHP array.
 */
class ArrayStorage implements TransferLoggerInterface, LogProviderInterface
{
    /**
     * @var array
     */
    private $logs = [];

    /**
     * @param RequestInterface $request
     * @param ResponseInterface|null $response
     * @param \Exception|null $exception
     * @param array $info
     */
    public function logHttpTransfer(RequestInterface $request, ResponseInterface $response = null, \Exception $exception = null, array $info = [])
    {
        $this->logs[] = [
            'request' => $request,
            'response' => $response,
            'exception' => $exception,
            'info' => $info,
        ];
    }

    /**
     * @return int
     */
    public function countHttpTransferLogs()
    {
        return \count($this->logs);
    }

    /**
     * @return array|\Traversable
     */
    public function getHttpTransferLogs()
    {
        return $this->logs;
    }
}
