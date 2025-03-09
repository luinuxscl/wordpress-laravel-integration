<?php

namespace Luinuxscl\WordpressIntegration\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Luinuxscl\WordpressIntegration\Services\WordpressService;
use Luinuxscl\WordpressIntegration\Models\WordpressCredential;

class WordpressController extends Controller
{
    protected WordpressService $wordpressService;

    public function __construct(WordpressService $wordpressService)
    {
        $this->wordpressService = $wordpressService;
    }

    /**
     * Crear un nuevo post en WordPress.
     */
    public function createPost(Request $request)
    {
        $request->validate([
            'site_url' => 'required|url',
            'username' => 'required|string',
            'password' => 'required|string',
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $credential = WordpressCredential::where('site_url', $request->site_url)->first();

        if (!$credential) {
            return response()->json(['error' => 'Credenciales de WordPress no encontradas'], 404);
        }

        $this->wordpressService->setCredential($credential);
        $post = $this->wordpressService->createPost($request->only(['title', 'content']));

        return response()->json($post, 201);
    }

    /**
     * Obtener un post de WordPress.
     */
    public function getPost(Request $request, int $id)
    {
        $credential = WordpressCredential::where('site_url', $request->query('site_url'))->first();

        if (!$credential) {
            return response()->json(['error' => 'Credenciales de WordPress no encontradas'], 404);
        }

        $this->wordpressService->setCredential($credential);
        $post = $this->wordpressService->getPost($id);

        return response()->json($post);
    }
}
