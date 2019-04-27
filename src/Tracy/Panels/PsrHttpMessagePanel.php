<?php

namespace Slepic\Tracy\Panels;

use Slepic\Psr\Http\TransferLog\LogProviderInterface;
use Tracy\IBarPanel;

/**
 * Class PsrHttpMessagePanel
 * @package Slepic\Tracy\Panels
 *
 * Tracy panel that can display HTTP messages transfered between the backend and dedicated http servers.
 */
class PsrHttpMessagePanel implements IBarPanel
{
    /**
     * @var LogProviderInterface
     */
    private $logProvider;

    /**
     * @var int
     */
    private $maxBodyLength;

    /**
     * PsrHttpMessagePanel constructor.
     * @param LogProviderInterface $logProvider
     * @param int|null $maxBodyLength
     */
    public function __construct(LogProviderInterface $logProvider, $maxBodyLength = null)
    {
        $this->logProvider = $logProvider;
        $this->maxBodyLength = $maxBodyLength ?: 1024;
    }

    /**
     * @return string
     */
    public function getTab()
    {
        ob_start(function () {
        });
        $count = $this->logProvider->countHttpTransferLogs();
        $logs = $this->logProvider->getHttpTransferLogs();
        list($totalDuration, $durationMisses) = $this->getTotalDuration($logs);
        require __DIR__ . '/PsrHttpMessagePanel/templates/tab.phtml';
        return ob_get_clean();
    }

    /**
     * @return string
     */
    public function getPanel()
    {
        ob_start(function () {
        });
        $count = $this->logProvider->countHttpTransferLogs();
        $logs = $this->logProvider->getHttpTransferLogs();
        list($totalDuration, $durationMisses) = $this->getTotalDuration($logs);
        $maxBodyLength = $this->maxBodyLength;
        require __DIR__ . '/PsrHttpMessagePanel/templates/panel.phtml';
        return ob_get_clean();
    }

    /**
     * @param iterable $logs
     * @return array
     */
    private function getTotalDuration($logs)
    {
        $duration = 0;
        $missing = 0;
        foreach ($logs as $log) {
            if (isset($log['info']['duration'])) {
                $duration += $log['info']['duration'];
            } else {
                $missing += 1;
            }
        }
        return [\round($duration * 1000, 1), $missing];
    }
}
