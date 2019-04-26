<?php

namespace Slepic\Psr\Http\TransferLog;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class LoggingGuzzleMiddleware
 * @package Slepic\Psr\Http\TransferLog
 *
 * This class can be pushed to \GuzzleHttp\HandlerStack to provide logging of http transfers.
 *
 * This is a more scalable alternative to GuzzleHttp\Middleware::log.
 * It can also sustain the work of Middleware::history, except it doesnt log the client options.
 *
 * This can be used instead of Middleware::log,
 * especially when you would pass PsrLoggerOverTransferLogger as its first argument.
 * And using this with TransferLoggerOverPsrLogger is useful if you need more control
 * over the log level used for logging then what is offered by Middleware::log.
 */
class LoggingGuzzleMiddleware
{
    /**
     * @var TransferLoggerInterface
     */
    private $logger;

    /**
     * LoggingGuzzleMiddleware constructor.
     * @param TransferLoggerInterface $logger
     */
    public function __construct(TransferLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param callable $handler
     * @return \Closure
     */
    public function __invoke(callable $handler)
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            return $handler($request, $options)->then(
                function (ResponseInterface $response) use ($request) {
                    $this->logger->logHttpTransfer($request, $response);
                    return $response;
                },
                function (\Exception $reason) use ($request) {
                    $response = $reason instanceof RequestException
                        ? $reason->getResponse()
                        : null;
                    $this->logger->logHttpTransfer($request, $response, $reason);
                    return \GuzzleHttp\Promise\rejection_for($reason);
                }
            );
        };
    }
}
