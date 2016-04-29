<?php

namespace DataSift\Feature;

use PHPUnit_Framework_TestCase;
use \Mockery as m;

class FeatureManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tear down after tests
     */
    protected function tearDown()
    {
        m::close();
    }

    /** @test */
    public function it_is_initializable()
    {
        $driver = m::mock('\DataSift\Feature\Driver\Services\DriverInterface');
        $featureManager = new FeatureManager($driver);
        $this->assertInstanceOf('DataSift\Feature\FeatureManager', $featureManager);
    }

    /** @test */
    public function it_should_call_is_enabled()
    {
        $driver = m::mock('\DataSift\Feature\Driver\Services\DriverInterface');
        $driver->shouldReceive('get')
            ->once()
            ->withAnyArgs(array("value", false));

        $featureManager = new FeatureManager($driver);
        $featureManager->isEnabled("value");
    }

    /**
     * DataProvider for falsey values
     *
     * @return array
     */
    public function falseyProvider()
    {
        return array(
            array('false'),
            array('')
        );
    }

    /**
     * @dataProvider falseyProvider
     *
     * @param string $value
     *
     * @test
     */
    public function it_should_handle_falsey_values($value)
    {
        $driver = m::mock('\DataSift\Feature\Driver\Services\DriverInterface');
        $driver->shouldReceive('get')
            ->twice()
            ->withAnyArgs(array("value", false))
            ->andReturn($value);

        $featureManager = new FeatureManager($driver);

        $this->assertFalse($featureManager->isEnabled('value'));
        $this->assertTrue($featureManager->isNotEnabled('value'));
    }
}
