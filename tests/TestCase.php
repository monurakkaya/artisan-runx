<?php

namespace Monurakkaya\ArtisanRunx\Tests;

use Illuminate\Console\Application;
use Illuminate\Database\Schema\Blueprint;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();

        Application::starting(function ($artisan) {
            $artisan->add(app(InspireCommand::class));
            $artisan->add(app(ManageFooCommand::class));
        });

    }

    protected function setUpDatabase(): void
    {
        $this->app['db']->connection()->getSchemaBuilder()->create('foos', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
        });

        for ($i = 0; $i < 10; $i++) {
            Foo::create();
        }
    }

    protected function getPackageProviders($app): array
    {
        return [
            'Monurakkaya\ArtisanRunx\Providers\ServiceProvider',
        ];
    }
}
