<?php


namespace Slepic\Tests\Tracy\Bar\PsrHttpMessagePanel;

use PHPUnit\Framework\TestCase;
use Slepic\Tracy\Bar\PsrHttpMessagePanel\Factory;
use Tracy\IBarPanel;

class FactoryTest extends TestCase
{
    /**
     * Test that the panel implements IBarPanel
     *
     * @return void
     */
    public function testImplements()
    {
        $panel = Factory::create([]);
        $this->assertInstanceOf(IBarPanel::class, $panel);
    }

    /**
     * Test the tab for presence of key components.
     *
     * @return void
     */
    public function testTab()
    {
        $tab = Factory::create([])->getTab();
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
        $panel = Factory::create(new \ArrayIterator())->getPanel();
        $this->assertContains('<div class="tracy-inner">', $panel);
        $this->assertContains('<div class="tracy-inner-container">', $panel);
        $this->assertContains('0 HTTP Transfers', $panel);
    }
}
