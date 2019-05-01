<?php


namespace Slepic\Tracy\Bar\PsrHttpMessagePanel;

use Slepic\Http\Transfer\Log\LogInterface;
use Slepic\Templating\Template\OutputBufferTemplate;
use Slepic\Tracy\Bar\TemplatedBarPanel\TemplatedBarPanel;
use Tracy\IBarPanel;

class Factory
{
    /**
     * @param LogInterface[]|\Traversable $logs
     * @return IBarPanel
     * @throws \Exception
     */
    public static function create($logs)
    {
        return new TemplatedBarPanel(
            new TemplateDataProvider($logs),
            new OutputBufferTemplate(__DIR__ . '/tab.phtml'),
            new OutputBufferTemplate(__DIR__ . '/panel.phtml')
        );
    }
}
