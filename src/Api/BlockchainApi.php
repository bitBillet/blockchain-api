<?php

namespace App\Api;

use App\Enum\Response\ResponseCode;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BlockchainApi
{
    private HttpClientInterface $client;

    public const URL = 'https://blockchain.info/ticker';
    public function __construct()
    {
        $this->client = HttpClient::createForBaseUri(self::URL);
    }

    /**
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getData(): array
    {
        $response = $this->client->request(
            'GET',
            self::URL
        );

        if ($response->getStatusCode() !== ResponseCode::SUCCESS->value) {
            throw new \Exception((string)$response->getInfo('error'));
        }

        return $response->toArray();
    }
}
