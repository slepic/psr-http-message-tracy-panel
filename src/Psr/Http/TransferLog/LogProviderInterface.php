<?php


namespace Slepic\Psr\Http\TransferLog;

/**
 * Class LogProviderInterface
 * @package Slepic\Psr\Http\TransferLog
 */
interface LogProviderInterface
{
    /**
     * Count the contained transfer logs.
     * @return int
     */
    public function countHttpTransferLogs();

    /**
     * Get iterator of the transfer logs.
     * @return array|\Traversable
     */
    public function getHttpTransferLogs();
}
