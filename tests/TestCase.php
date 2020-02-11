<?php

declare(strict_types=1);

namespace Vural\E2ERoutes\Tests;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as Orchestra;
use Vural\E2ERoutes\E2ERoutesServiceProvider;

class TestCase extends Orchestra
{
    public function setUp() : void
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/factories');
    }

    /**
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app) : void
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $this->setUpDatabase($app);
    }

    /**
     * @param Application $app
     *
     * @return array<int, string>
     */
    protected function getPackageProviders($app) : array
    {
        return [E2ERoutesServiceProvider::class];
    }

    protected function productionEnvironment(Application $app) : void
    {
        $app['env'] = 'production';
    }

    protected function localEnvironment(Application $app) : void
    {
        $app['env'] = 'local';
    }

    protected function setUpDatabase(Application $app) : void
    {
        /** @var DatabaseManager $dbManager */
        $dbManager = $app['db'];

        $dbManager->connection()->getSchemaBuilder()->create('users', static function (Blueprint $table) : void {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamps();
        });

        $dbManager->connection()->getSchemaBuilder()->create('accounts', static function (Blueprint $table) : void {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedInteger('user_id');
            $table->bigInteger('balance');
        });
    }
}
