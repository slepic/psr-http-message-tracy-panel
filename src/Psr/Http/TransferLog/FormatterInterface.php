<?php

namespace Slepic\Psr\Http\TransferLog;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface MessageFormatterInterface
 * @package Slepic\Psr\Http\TransferLog
 *
 * Provides way of transforming transfer http request, response and potentialy an exception into a single message.
 */
interface FormatterInterface
{
    /**
     * Formats transfer log to a single string message representing all the important data.
     *
     * What is important and what is not, is up to the implementations.
     *
     * @param RequestInterface $request
     * @param ResponseInterface|null $response
     * @param \Exception|null $exception
     * @return string
     */
    public function formatTransferLog(RequestInterface $request, ResponseInterface $response = null, \Exception $exception = null);
}
