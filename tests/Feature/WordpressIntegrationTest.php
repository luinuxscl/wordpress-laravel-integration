<?php

namespace Luinuxscl\WordpressIntegration\Tests\Feature;

use Luinuxscl\WordpressIntegration\Models\WordpressCredential;
use Luinuxscl\WordpressIntegration\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WordpressIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_wordpress_post()
    {
        $credential = WordpressCredential::create([
            'site_url' => 'https://example.com',
            'username' => 'admin',
            'password' => 'password',
            'is_default' => true,
            'site_name' => 'Example Site',
        ]);

        $response = $this->postJson(route('wordpress.createPost'), [
            'site_url' => $credential->site_url,
            'username' => $credential->username,
            'password' => $credential->password,
            'title' => 'Test Post',
            'content' => 'This is a test post.',
        ]);

        $response->assertStatus(201);
    }
}
