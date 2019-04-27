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
     * Test the tab for presence of key components.
     *
     * @return void
     */
    public function testTab()
    {
        $this->setupProvider();
        $tab = $this->panel->getTab();
        $this->assertContains('<span title="See the logged HTTP transfers">', $tab);
        $this->assertContains('<span class="tracy-label">0 (0 ms)</span>', $tab);
    }

    /**
     * Test the panel for presence of key components.
     *
     * @return void
     */
    public function testPanel()
    {
        $this->setupProvider();
        $panel = $this->panel->getPanel();
        $this->assertContains('<div class="tracy-inner">', $panel);
        $this->assertContains('<div class="tracy-inner-container">', $panel);
        $this->assertContains('0 HTTP Transfers', $panel);
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
