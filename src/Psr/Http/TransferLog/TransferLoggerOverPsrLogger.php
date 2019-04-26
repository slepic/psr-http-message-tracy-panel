<?php

namespace Slepic\Psr\Http\TransferLog;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class TransferLoggerOverPsrLogger
 * @package Slepic\Psr\Http\TransferLog
 *
 * This class adapts a LoggerInterface to provide TransferLoggerInterface.
 * Log level evaluation strategy is required to achieve this.
 */
class TransferLoggerOverPsrLogger implements TransferLoggerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var FormatterInterface
     */
    private $formatter;

    /**
     * @var LogLevelEvaluatorInterface
     */
    private $levelEvaluator;

    /**
     * TransferLoggerOverPsrLogger constructor.
     * @param LoggerInterface $logger
     * @param FormatterInterface $formatter
     * @param LogLevelEvaluatorInterface $levelEvaluator
     */
    public function __construct(
        LoggerInterface $logger,
        FormatterInterface $formatter,
        LogLevelEvaluatorInterface $levelEvaluator
    ) {
        $this->logger = $logger;
        $this->formatter = $formatter;
        $this->levelEvaluator = $levelEvaluator;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface|null $response
     * @param \Exception|null $exception
     */
    public function logHttpTransfer(RequestInterface $request, ResponseInterface $response = null, \Exception $exception = null)
    {
        $logLevel = $this->levelEvaluator->getLogLevel($request, $response, $exception);
        $message = $this->formatter->formatTransferLog($request, $response, $exception);
        $this->logger->log($logLevel, $message, [
            'request' => $request,
            'response' => $response,
            'exception' => $exception,
        ]);
    }
}
