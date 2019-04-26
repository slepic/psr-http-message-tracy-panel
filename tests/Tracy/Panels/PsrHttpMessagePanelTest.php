<?php

namespace Slepic\Tests\Tracy\Panels;

use PHPUnit\Framework\TestCase;
use Slepic\Psr\Http\TransferLog\LogProviderInterface;
use Slepic\Tracy\Panels\PsrHttpMessagePanel;
use Tracy\IBarPanel;

class PsrHttpMessagePanelTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|LogProviderInterface
     */
    private $logProvider;

    /**
     * @var PsrHttpMessagePanel
     */
    private $panel;

    /**
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->logProvider = $this->createMock(LogProviderInterface::class);
        $this->panel = new PsrHttpMessagePanel($this->logProvider);
    }

    /**
     * Test that the panel implements IBarPanel
     *
     * @return void
     */
    public function testImplements()
    {
        $this->assertInstanceOf(IBarPanel::class, $this->panel);
    }

    /**
     * Test that the tab contains message count.
     *
     * @return void
     */
    public function testTabContainsMessageCount()
    {
        $this->setupProvider();
        $tab = $this->panel->getTab();
        $this->assertContains('<span class="tracy-label">0</span>', $tab);
    }

    /**
     * Test that the panel contains message count.
     *
     * @return void
     */
    public function testPanelContainsMessageCount()
    {
        $this->setupProvider();
        $panel = $this->panel->getPanel();
        $this->assertContains('<h1>HTTP messages sent: 0</h1>', $panel);
    }

    /**
     * Setup log provider mock to provide given logs.
     *
     * @param array $logs
     * @return void
     */
    private function setupProvider(array $logs = [])
    {
        $this->logProvider->method('countHttpTransferLogs')
            ->willReturn(\count($logs));
        $this->logProvider->method('getHttpTransferLogs')
            ->willReturn($logs);
    }
}
