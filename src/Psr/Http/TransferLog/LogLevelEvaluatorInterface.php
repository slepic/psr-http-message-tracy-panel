<?php


namespace Slepic\Psr\Http\TransferLog;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface LogLevelEvaluatorInterface
 * @package Slepic\Psr\Http\TransferLog
 *
 * This interface provides strategy for logging http transfers using TransferLoggerOverPsrLogger.
 */
interface LogLevelEvaluatorInterface
{
    /**
     * Evaluate the log level of a transfer.
     *
     * @param RequestInterface $request
     * @param ResponseInterface|null $response
     * @param \Exception|null $exception
     * @return string
     */
    public function getLogLevel(RequestInterface $request, ResponseInterface $response = null, \Exception $exception = null);
}
