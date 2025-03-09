<?php

namespace Luinuxscl\WordpressIntegration\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Luinuxscl\WordpressIntegration\Providers\WordpressServiceProvider;

abstract class TestCase extends BaseTestCase
{
    /**
     * Cargar los providers necesarios.
     */
    protected function getPackageProviders($app)
    {
        return [WordpressServiceProvider::class];
    }

    /**
     * Configurar el entorno de pruebas.
     */
    protected function getEnvironmentSetUp($app)
    {
        // Configurar base de datos en memoria
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}
