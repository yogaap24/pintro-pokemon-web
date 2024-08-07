<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ApiHelper
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('API_URL'),
        ]);
    }

    public function loginToApi($url, $username, $password)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post($url . '/users/login', [
                'json' => [
                    'username' => $username,
                    'password' => $password,
                ],
            ]);

            $body = $response->getBody()->getContents();
            Log::info('API Response: ' . $body);
            return json_decode($body, true);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error('Client error: ' . $e->getResponse()->getBody()->getContents());
            return ['error' => 'Client error: ' . $e->getMessage()];
        } catch (\Exception $e) {
            Log::error('General error: ' . $e->getMessage());
            return ['error' => 'General error: ' . $e->getMessage()];
        }
    }

    public static function listPokemons($url, $limit = 10, $offset = 0)
    {
        try {
            $client = new \GuzzleHttp\Client();

            $response = $client->get($url, [
                'query' => [
                    'limit' => $limit,
                    'offset' => $offset,
                ],
            ]);

            $body = $response->getBody()->getContents();
            Log::info('API Response: ' . $body);

            return json_decode($body, true);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error('Client error: ' . $e->getResponse()->getBody()->getContents());
            throw new \Exception('Client error: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General error: ' . $e->getMessage());
            throw new \Exception('General error: ' . $e->getMessage());
        }
    }

    public static function getPokemon($url, $id = null, $name = null)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get($url . '/' . $id ?? $name);

            $body = $response->getBody()->getContents();
            Log::info('API Response: ' . $body);

            return json_decode($body, true);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error('Client error: ' . $e->getResponse()->getBody()->getContents());
            throw new \Exception('Client error: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General error: ' . $e->getMessage());
            throw new \Exception('General error: ' . $e->getMessage());
        }
    }

    
}
