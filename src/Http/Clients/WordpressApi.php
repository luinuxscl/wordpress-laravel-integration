<?php

namespace Luinux\WordpressLaravelIntegration\Http\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Luinux\WordpressLaravelIntegration\Models\WordpressCredential;

class WordpressApi
{
    /**
     * El cliente HTTP.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * La URL base de WordPress.
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Las credenciales para la API de WordPress.
     *
     * @var array
     */
    protected $credentials = [];

    /**
     * La versión de la API.
     *
     * @var string
     */
    protected $apiVersion;

    /**
     * Crear una nueva instancia del cliente.
     *
     * @param \GuzzleHttp\Client|null $client
     * @return void
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?? new Client([
            'timeout' => config('wordpress.api.timeout', 30),
            'http_errors' => false,
        ]);

        $this->baseUrl = config('wordpress.url');
        $this->apiVersion = config('wordpress.api.version', 'wp/v2');

        // Intentar cargar credenciales desde la base de datos
        $this->loadCredentials();

        // Si no hay credenciales en BD, usar las del .env
        if (empty($this->credentials['username'])) {
            $this->credentials = [
                'username' => config('wordpress.username'),
                'password' => config('wordpress.password'),
            ];
        }
    }

    /**
     * Cargar credenciales desde la base de datos.
     *
     * @return void
     */
    protected function loadCredentials()
    {
        try {
            $credential = WordpressCredential::where('is_active', true)->first();

            if ($credential) {
                $this->baseUrl = $credential->url;

                $this->credentials = [
                    'username' => $credential->username,
                    'password' => $credential->password,
                ];
            }
        } catch (\Exception $e) {
            Log::error('Error cargando credenciales de WordPress: ' . $e->getMessage());
        }
    }

    /**
     * Realizar una petición a la API.
     *
     * @param string $method
     * @param string $endpoint
     * @param array $params
     * @return array|null
     */
    protected function request($method, $endpoint, array $params = [])
    {
        $url = rtrim($this->baseUrl, '/') . '/wp-json/' . $this->apiVersion . '/' . ltrim($endpoint, '/');

        try {
            $options = [];

            // Agregar autenticación si hay credenciales disponibles
            if (!empty($this->credentials['username']) && !empty($this->credentials['password'])) {
                $options['auth'] = [
                    $this->credentials['username'],
                    $this->credentials['password'],
                ];
            }

            // Configurar parámetros según el método
            if ($method === 'GET') {
                $options['query'] = $params;
            } else {
                $options['json'] = $params;
            }

            $response = $this->client->request($method, $url, $options);
            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody(), true);

            if ($statusCode >= 200 && $statusCode < 300) {
                return $body;
            }

            Log::error('Error en API WordPress', [
                'url' => $url,
                'status' => $statusCode,
                'response' => $body
            ]);

            return null;
        } catch (RequestException $e) {
            Log::error('Error en petición a WordPress API: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtener información del sitio WordPress.
     *
     * @return array|null
     */
    public function getSiteInfo()
    {
        return $this->request('GET', '');
    }

    /**
     * Obtener posts de WordPress.
     *
     * @param array $params
     * @return array|null
     */
    public function getPosts(array $params = [])
    {
        $defaultParams = [
            'per_page' => config('wordpress.api.per_page', 10),
        ];

        return $this->request('GET', '/posts', array_merge($defaultParams, $params));
    }

    /**
     * Obtener un post específico por ID.
     *
     * @param int $id
     * @return array|null
     */
    public function getPost(int $id)
    {
        return $this->request('GET', '/posts/' . $id);
    }

    /**
     * Crear un nuevo post en WordPress.
     *
     * @param array $data
     * @return array|null
     */
    public function createPost(array $data)
    {
        return $this->request('POST', '/posts', $data);
    }

    /**
     * Actualizar un post existente.
     *
     * @param int $id
     * @param array $data
     * @return array|null
     */
    public function updatePost(int $id, array $data)
    {
        return $this->request('POST', '/posts/' . $id, $data);
    }

    /**
     * Eliminar un post.
     *
     * @param int $id
     * @return bool
     */
    public function deletePost(int $id)
    {
        $response = $this->request('DELETE', '/posts/' . $id, ['force' => true]);
        return !empty($response);
    }

    /**
     * Obtener categorías de WordPress.
     *
     * @param array $params
     * @return array|null
     */
    public function getCategories(array $params = [])
    {
        $defaultParams = [
            'per_page' => 100,
        ];

        return $this->request('GET', '/categories', array_merge($defaultParams, $params));
    }

    /**
     * Obtener tags de WordPress.
     *
     * @param array $params
     * @return array|null
     */
    public function getTags(array $params = [])
    {
        $defaultParams = [
            'per_page' => 100,
        ];

        return $this->request('GET', '/tags', array_merge($defaultParams, $params));
    }

    /**
     * Obtener usuarios de WordPress.
     *
     * @param array $params
     * @return array|null
     */
    public function getUsers(array $params = [])
    {
        return $this->request('GET', '/users', $params);
    }

    /**
     * Obtener medios de WordPress.
     *
     * @param array $params
     * @return array|null
     */
    public function getMedia(array $params = [])
    {
        return $this->request('GET', '/media', $params);
    }

    /**
     * Subir un medio a WordPress.
     *
     * @param string $filePath
     * @param array $data
     * @return array|null
     */
    public function uploadMedia($filePath, array $data = [])
    {
        // Implementación para subir medios
        // Esto requiere una implementación específica usando multipart/form-data
        // que se puede agregar según necesidades específicas
        return null;
    }
}
