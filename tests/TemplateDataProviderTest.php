<?php


namespace Slepic\Tests\Tracy\Bar\PsrHttpMessagePanel;

use PHPUnit\Framework\TestCase;
use Slepic\Http\Transfer\Log\LogInterface;
use Slepic\Tracy\Bar\PsrHttpMessagePanel\TemplateDataProvider;
use Slepic\Tracy\Bar\TemplatedBarPanel\TemplateDataProviderInterface;

class TemplateDataProviderTest extends TestCase
{
    public function testImplements()
    {
        $provider = new TemplateDataProvider([]);
        $this->assertInstanceOf(TemplateDataProviderInterface::class, $provider);
    }


    /**
     * @param $logs
     * @dataProvider provideData
     */
    public function testTab($logs)
    {
        $provider = new TemplateDataProvider($logs);
        $data = $provider->getTabData();
        $this->assertArrayHasKey('count', $data);
        $this->assertArrayHasKey('totalDuration', $data);
    }

    /**
     * @param $logs
     * @dataProvider provideData
     */
    public function testPanel($logs)
    {
        $provider = new TemplateDataProvider($logs);
        $data = $provider->getPanelData();
        $this->assertArrayHasKey('count', $data);
        $this->assertInternalType('integer', $data['count']);
        $this->assertArrayHasKey('logs', $data);
        $this->assertSame($logs, $data['logs']);
        $this->assertArrayHasKey('totalDuration', $data);
        $this->assertInternalType('float', $data['totalDuration']);
    }

    public function provideData()
    {
        return [
            [[]],
            [[
                $this->createMock(LogInterface::class),
                $this->createMock(LogInterface::class),
                $this->createMock(LogInterface::class),
            ]]
        ];
    }
}
