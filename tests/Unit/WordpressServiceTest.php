<?php

namespace Luinuxscl\WordpressIntegration\Tests\Unit;

use Luinuxscl\WordpressIntegration\Models\WordpressCredential;
use Luinuxscl\WordpressIntegration\Services\WordpressService;
use Luinuxscl\WordpressIntegration\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class WordpressServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sets_and_retrieves_credentials()
    {
        $service = new WordpressService();

        $credential = WordpressCredential::create([
            'site_url' => 'https://example.com',
            'username' => 'admin',
            'password' => 'password',
            'is_default' => true,
            'site_name' => 'Example Site',
        ]);

        $service->setCredential($credential);
        $this->assertEquals($credential, $service->getCredentials());
    }
}
