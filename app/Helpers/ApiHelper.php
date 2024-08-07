<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
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
            $response = $this->client->post($url . '/users/login', [
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

    public function listPokemons($limit = 10, $offset = 0)
    {
        $token = Session::get('token');
        $url = '/pokemon';

        try {
            $response = $this->client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
                'query' => [
                    'limit' => $limit,
                    'offset' => $offset,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return [
                'pokemons' => $data['results'] ?? [],
                'total' => $data['count'] ?? 0,
            ];
        } catch (RequestException $e) {
            Log::error('API request failed: ' . $e->getMessage());
            throw new \Exception('Failed to retrieve pokemons');
        }
    }

    public function getPokemon($id = null, $name = null)
    {
        $token = Session::get('token');
        $url = '/pokemon';

        try {
            $response = $this->client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
                'query' => [
                    'id' => $id,
                    'name' => $name,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            Log::error('API request failed: ' . $e->getMessage());
            throw new \Exception('Failed to retrieve pokemon');
        }
    }
}