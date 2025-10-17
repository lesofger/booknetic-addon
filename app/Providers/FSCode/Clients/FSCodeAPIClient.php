<?php

namespace BookneticApp\Providers\FSCode\Clients;

use BookneticVendor\GuzzleHttp\Client;
use BookneticVendor\GuzzleHttp\Exception\GuzzleException;

class FSCodeAPIClient
{
    private const API_URL = 'https://api.fs-code.com/v3/';
    private ?string $proxy = null;
    private Client $client;

    private FSCodeAPIClientContextDto $context;

    public function __construct(FSCodeAPIClientContextDto $context)
    {
        $this->context = $context;
        $this->client = $this->createClient();
    }

    private function createClient(): Client
    {
        return new Client([
            'verify' => false,
            'proxy' => $this->proxy ?: null,
            'headers' => [
                'X-License-Code'      => $this->context->licenseCode,
                'X-Website'           => $this->context->website,
                'X-Product-Version'   => $this->context->productVersion,
                'X-PHP-Version'       => $this->context->phpVersion,
                'X-Wordpress-Version' => $this->context->wordpressVersion,
                'Content-type'        => 'application/json',
                'Accept'              => 'application/json',
            ],
        ]);
    }

    public function request($endpoint, $method = 'GET', $data = [])
    {
        $url = static::API_URL . $endpoint;

        $options = [];

        if ($method === 'POST' && ! empty($data)) {
            $options['form_params'] = $data;
        } elseif ($method === 'GET' && ! empty($data)) {
            $options['query'] = $data;
        }

        try {
            $response = $this->client->request($method, $url, $options);
            $response = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\Exception|GuzzleException $e) {
            $response = [];
        }

        return $response;
    }

    public function setProxy($proxy): FSCodeAPIClient
    {
        $this->proxy = $proxy;

        return $this;
    }

    public static function uploadFileFromName(string $name, string $dst): void
    {
        $url = sprintf('%s/%s', self::API_URL, $name);

        self::uploadFileFromUrl($url, $dst);
    }

    public static function uploadFileFromUrl(string $src, string $dst): void
    {
        $img = file_get_contents($src);

        file_put_contents($dst, $img);
    }
}
