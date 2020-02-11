<?php

declare(strict_types=1);

namespace Vural\E2ERoutes\Tests;

use Illuminate\Foundation\Application;

class RouteTest extends TestCase
{
    /**
     * @test
     * @environment-setup productionEnvironment
     */
    function it_does_not_registers_routes_in_production() : void
    {
        $this->assertFalse($this->app->get('router')->getRoutes()->hasNamedRoute('e2e-routes.reset'));
    }

    /**
     * @test
     * @environment-setup useFooAsRoutePrefix
     */
    function it_can_change_prefix_from_config() : void
    {
        $this->assertSame('foo', $this->app->get('router')->getRoutes()->getByName('e2e-routes.reset')->getPrefix());
    }

    /**
     * @test
     * @environment-setup useFooAsRouteName
     */
    function it_can_change_route_group_name_from_config() : void
    {
        $this->assertTrue($this->app->get('router')->getRoutes()->hasNamedRoute('foo.reset'));
    }

    protected function useFooAsRoutePrefix(Application $app) : void
    {
        $app['config']->set('e2e-routes.prefix', 'foo');
    }

    protected function useFooAsRouteName(Application $app) : void
    {
        $app['config']->set('e2e-routes.name', 'foo');
    }
}
