<?php

namespace Luinuxscl\WordpressIntegration\Services;

use GuzzleHttp\Client;
use Luinuxscl\WordpressIntegration\Models\WordpressCredential;
use Illuminate\Database\Eloquent\Model;

class WordpressService
{
    protected Client $client;
    protected ?WordpressCredential $credential = null;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 10,
        ]);
    }

    /**
     * Establece las credenciales para la comunicación con la API.
     */
    public function setCredential(WordpressCredential $credential): void
    {
        $this->credential = $credential;
    }

    /**
     * Método genérico para realizar peticiones a la API.
     */
    protected function request(string $method, string $url, array $options = [])
    {
        if (!$this->credential) {
            throw new \Exception('No hay credenciales de WordPress configuradas.');
        }

        $options['auth'] = [
            $this->credential->username,
            $this->credential->password,
        ];

        try {
            $fullUrl = $this->credential->site_url . $url;
            $response = $this->client->request($method, $fullUrl, $options);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Métodos CRUD para Posts
     */
    public function createPost(array $data)
    {
        return $this->request('POST', '/wp-json/wp/v2/posts', ['json' => $data]);
    }

    public function getPost(int $id)
    {
        return $this->request('GET', "/wp-json/wp/v2/posts/{$id}");
    }

    public function updatePost(int $id, array $data)
    {
        return $this->request('PUT', "/wp-json/wp/v2/posts/{$id}", ['json' => $data]);
    }

    public function deletePost(int $id)
    {
        return $this->request('DELETE', "/wp-json/wp/v2/posts/{$id}");
    }

    /**
     * Métodos CRUD para Categorías
     */
    public function createCategory(array $data)
    {
        return $this->request('POST', '/wp-json/wp/v2/categories', ['json' => $data]);
    }

    public function getCategory(int $id)
    {
        return $this->request('GET', "/wp-json/wp/v2/categories/{$id}");
    }

    public function updateCategory(int $id, array $data)
    {
        return $this->request('PUT', "/wp-json/wp/v2/categories/{$id}", ['json' => $data]);
    }

    public function deleteCategory(int $id)
    {
        return $this->request('DELETE', "/wp-json/wp/v2/categories/{$id}");
    }

    /**
     * Métodos CRUD para Tags
     */
    public function createTag(array $data)
    {
        return $this->request('POST', '/wp-json/wp/v2/tags', ['json' => $data]);
    }

    public function getTag(int $id)
    {
        return $this->request('GET', "/wp-json/wp/v2/tags/{$id}");
    }

    public function updateTag(int $id, array $data)
    {
        return $this->request('PUT', "/wp-json/wp/v2/tags/{$id}", ['json' => $data]);
    }

    public function deleteTag(int $id)
    {
        return $this->request('DELETE', "/wp-json/wp/v2/tags/{$id}");
    }

    /**
     * Subida de archivos (por ejemplo, imágenes)
     */
    public function uploadMedia(string $filePath, array $additionalOptions = [])
    {
        $options = [
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => fopen($filePath, 'r'),
                ],
            ],
        ];

        $options = array_merge($options, $additionalOptions);
        return $this->request('POST', '/wp-json/wp/v2/media', $options);
    }

    /**
     * Obtener métricas básicas utilizando headers de la respuesta.
     */
    public function getMetrics()
    {
        try {
            $response = $this->client->request('GET', $this->credential->site_url . '/wp-json/wp/v2/posts', [
                'auth' => [
                    $this->credential->username,
                    $this->credential->password,
                ],
            ]);
            return [
                'total_posts' => $response->getHeaderLine('X-WP-Total'),
            ];
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
