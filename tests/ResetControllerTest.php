<?php

declare(strict_types=1);

namespace Vural\E2ERoutes\Tests;

use Illuminate\Contracts\Console\Kernel;
use Mockery;
use function route;

class ResetControllerTest extends TestCase
{
    /** @test */
    function it_will_reset_the_database() : void
    {
        $migrateCommand = Mockery::mock('\Illuminate\Database\Console\Migrations\RefreshCommand[handle]');
        $migrateCommand->shouldReceive('handle')->once();
        $this->app[Kernel::class]->registerCommand($migrateCommand);

        $this->getJson(route('e2e-routes.reset'))->assertOk();
    }

    /** @test */
    function it_can_run_seeder_if_requested()
    {
        $migrateCommand = Mockery::mock('\Illuminate\Database\Console\Migrations\RefreshCommand[runSeeder]');
        $migrateCommand->shouldAllowMockingProtectedMethods();
        $migrateCommand->shouldReceive('runSeeder')->once();
        $this->app[Kernel::class]->registerCommand($migrateCommand);

        $this->getJson(route('e2e-routes.reset', 'seed'))->assertOk();
    }
}
