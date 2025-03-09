<?php

namespace Luinuxscl\WordpressIntegration;

use Luinuxscl\WordpressIntegration\Services\WordpressService;

class WordpressIntegration
{
    protected WordpressService $service;

    public function __construct(WordpressService $service)
    {
        $this->service = $service;
    }

    /**
     * Crear un nuevo post en WordPress.
     */
    public function createPost(array $data)
    {
        return $this->service->createPost($data);
    }

    /**
     * Obtener un post de WordPress.
     */
    public function getPost(int $id)
    {
        return $this->service->getPost($id);
    }
}
