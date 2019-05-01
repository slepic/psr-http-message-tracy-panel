<?php


namespace Slepic\Tracy\Bar\PsrHttpMessagePanel;

use Slepic\Http\Transfer\Log\LogInterface;
use Slepic\Tracy\Bar\TemplatedBarPanel\TemplateDataProviderInterface;

class TemplateDataProvider implements TemplateDataProviderInterface
{
    /**
     * @var array|LogInterface[]|\Traversable
     */
    private $logs;

    /**
     * TemplateDataProvider constructor.
     * @param array|LogInterface[]|\Traversable $logs
     */
    public function __construct($logs)
    {
        if (!\is_array($logs) && !$logs instanceof \Traversable) {
            throw new \Exception('Expected array of iterator.');
        }
        $this->logs = $logs;
    }

    /**
     * @return array
     */
    public function getTabData()
    {
        return $this->getData();
    }

    /**
     * @return array
     */
    public function getPanelData()
    {
        return $this->getData();
    }

    /**
     * @return array
     */
    private function getData()
    {
        $count = 0;
        $totalDuration = 0.0;
        foreach ($this->logs as $log) {
            $totalDuration += $log->getEndTime() - $log->getStartTime();
            ++$count;
        }
        return [
            'logs' => $this->logs,
            'count' => $count,
            'totalDuration' => $totalDuration,
        ];
    }
}
