<?php

namespace Luinuxscl\WordpressIntegration\Livewire;

use Livewire\Component;
use Luinuxscl\WordpressIntegration\Models\WordpressCredential;
use Illuminate\Support\Facades\Http;

class CreateWordpressCredential extends Component
{
    public $site_url;
    public $username;
    public $password;
    public $showModal = false;
    public $showButton = true;
    public $is_default = false;

    protected $rules = [
        'site_url' => 'required|url',
        'username' => 'required|string',
        'password' => 'required|string',
        'is_default' => 'boolean',
    ];

    protected $listeners = ['openModal'];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function create()
    {
        $this->validate();

        if (WordpressCredential::where('site_url', $this->site_url)->where('username', $this->username)->exists()) {
            session()->flash('message', __('A credential for this site and username already exists.'));
            return;
        }

        $response = Http::withBasicAuth($this->username, $this->password)->get($this->site_url . '/wp-json');

        if ($response->failed()) {
            session()->flash('message', __('Failed to connect to WordPress site.'));
            return;
        }

        $site_name = $response->json('name');

        WordpressCredential::create([
            'site_url' => $this->site_url,
            'username' => $this->username,
            'password' => $this->password,
            'site_name' => $site_name,
            'is_default' => $this->is_default,
        ]);

        $this->reset(['site_url', 'username', 'password', 'is_default', 'showModal']);

        session()->flash('message', 'WordPress credentials created successfully.');
    }

    public function render()
    {
        return view('wordpress::livewire.create-wordpress-credential');
    }
}
