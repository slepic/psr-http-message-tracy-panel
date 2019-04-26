<?php

namespace Slepic\Psr\Http\TransferLog;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\AbstractLogger;

/**
 * Class PsrLoggerOverTransferLogger
 * @package Slepic\Psr\Http\TransferLog
 *
 * This class adapts a TransferLoggerInterface to provide \Psr\Log\LoggerInterface.
 *
 * Log level and message are ignored, as well as any context components other then request, response and exception
 * which must be of type RequestInterface, ResponseInterface and Exception respectively.
 */
class PsrLoggerOverTransferLogger extends AbstractLogger
{
    /**
     * @var TransferLoggerInterface
     */
    private $logger;

    /**
     * PsrLoggerOverTransferLogger constructor.
     * @param TransferLoggerInterface $logger
     */
    public function __construct(TransferLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param mixed $level
     * @param string $message
     * @param array $context
     */
    public function log($level, $message, array $context = [])
    {
        if (isset($context['request'])) {
            $request = $context['request'];
            $response = null;
            $exception = null;
            if ($request instanceof RequestInterface) {
                if (isset($context['response'])) {
                    $response = $context['response'];
                    if (!$response instanceof ResponseInterface) {
                        $response = null;
                    }
                }
                if (isset($context['exception'])) {
                    $exception = $context['exception'];
                    if (!$exception instanceof \Exception) {
                        $exception = null;
                    }
                }
            }
            if (isset($response) || isset($exception)) {
                $this->logger->logHttpTransfer($request, $response, $exception);
            }
        }
    }
}
