<?php

namespace Slepic\Psr\Http\TransferLog;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface TransferLoggerInterface
 * @package Slepic\Psr\Http\TransferLog
 *
 * Allows logging of PSR HTTP message transfers.
 * A transfer is represented by a request, and a response and/or exception.
 */
interface TransferLoggerInterface
{
    /**
     * Logs a successful or unsuccessful transfer.
     *
     * @param RequestInterface $request
     * @param ResponseInterface|null $response
     * @param \Exception|null $exception
     * @param array $info Optional information about the transfer
     * @return void
     */
    public function logHttpTransfer(RequestInterface $request, ResponseInterface $response = null, \Exception $exception = null, array $info = []);
}
