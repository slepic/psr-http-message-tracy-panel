<?php

namespace Slepic\Psr\Http\TransferLog;

use GuzzleHttp\MessageFormatter;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class GuzzleMessageFormatter
 * @package Slepic\Psr\Http\TransferLog
 *
 * This class adapts a GuzzleHttp\MessageFormatter to provide MessageFormatterInterface.
 */
class GuzzleMessageFormatter implements FormatterInterface
{
    /**
     * @var MessageFormatter
     */
    private $formatter;

    /**
     * GuzzleMessageFormatter constructor.
     * @param MessageFormatter $formatter
     */
    public function __construct(MessageFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface|null $response
     * @param \Exception|null $exception
     * @return string
     */
    public function formatTransferLog(RequestInterface $request, ResponseInterface $response = null, \Exception $exception = null)
    {
        return $this->formatter->format($request, $response, $exception);
    }
}
