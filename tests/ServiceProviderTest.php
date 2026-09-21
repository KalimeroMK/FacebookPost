<?php

declare(strict_types=1);

namespace Kalimeromk\FacebookPost\Tests;

use Kalimeromk\FacebookPost\Services\FacebookPostService;
use Orchestra\Testbench\TestCase;

final class ServiceProviderTest extends TestCase
{
    public function testEverythingDeclaredForAutoDiscoveryExists(): void
    {
        $manifest = json_decode((string) file_get_contents(__DIR__ . '/../composer.json'), true);
        $laravel = $manifest['extra']['laravel'] ?? [];

        foreach ($laravel['providers'] ?? [] as $provider) {
            $this->assertTrue(class_exists($provider), $provider . ' is declared but does not exist');
        }

        foreach ($laravel['aliases'] ?? [] as $alias => $class) {
            $this->assertTrue(class_exists($class), $class . ' is aliased as ' . $alias . ' but does not exist');
        }
    }

    public function testTheServiceConstructsWithoutConfiguration(): void
    {
        // An application that has not set FACEBOOK_PAGE_ID must not get a TypeError.
        $this->assertInstanceOf(FacebookPostService::class, new FacebookPostService());
    }

    protected function getPackageProviders($app): array
    {
        return [\Kalimeromk\FacebookPost\FacebookPostServiceProvider::class];
    }
}
