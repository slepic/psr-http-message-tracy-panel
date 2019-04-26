<?php

namespace Slepic\Psr\Http\TransferLog;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LogLevel;

/**
 * Class DefaultTransferLogLevelEvaluator
 * @package Slepic\Psr\Http\TransferLog
 *
 * This class provides constant level evaluation strategy separately for each "hundred" group of HTTP status codes
 * plus a few separate log levels for cases when no response object is available.
 */
class DefaultLogLevelEvaluator implements LogLevelEvaluatorInterface
{
    /**
     * Log level used when only request is present.
     * @var string
     */
    public $onlyRequestLevel = LogLevel::ERROR;

    /**
     * Log level used when exception is present but no response object.
     * @var string
     */
    public $onlyExceptionLevel = LogLevel::ERROR;

    /**
     * Log level used when both exception and response are present.
     *
     * If this is null, then exception is ignored and level is evaluated according to response status code.
     *
     * @var string|null
     */
    public $allLevel = null;

    /**
     * Log level used when no exception is present and response status code is in 5xx family.
     * @var string
     */
    public $status5xxLevel = LogLevel::ERROR;

    /**
     * Log level used when no exception is present and response status code is in 4xx family.
     * @var string
     */
    public $status4xxLevel = LogLevel::ERROR;

    /**
     * Log level used when no exception is present and response status code is in 3xx family.
     * @var string
     */
    public $status3xxLevel = LogLevel::NOTICE;

    /**
     * Log level used when no exception is present and response status code is in 2xx family.
     * @var string
     */
    public $status2xxLevel = LogLevel::INFO;

    /**
     * Log level used when no exception is present and response status code is in 1xx family.
     * @var string
     */
    public $status1xxLevel = LogLevel::INFO;

    /**
     * @param RequestInterface $request
     * @param ResponseInterface|null $response
     * @param \Exception|null $exception
     * @return string
     */
    public function getLogLevel(RequestInterface $request, ResponseInterface $response = null, \Exception $exception = null)
    {
        if ($exception !== null) {
            if ($response === null) {
                return $this->onlyExceptionLevel;
            } elseif ($this->allLevel !== null) {
                return $this->allLevel;
            }
        }
        if ($response === null) {
            return $this->onlyRequestLevel;
        }
        $status = $response->getStatusCode();
        if ($status >= 500) {
            return $this->status5xxLevel;
        }
        if ($status >= 400) {
            return $this->status4xxLevel;
        }
        if ($status >= 300) {
            return $this->status3xxLevel;
        }
        if ($status >= 200) {
            return $this->status2xxLevel;
        }
        return $this->status1xxLevel;
    }
}
