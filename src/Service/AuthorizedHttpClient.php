<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class AuthorizedHttpClient
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private RequestStack $requestStack
    ) {}

    public function request(string $method, string $url, array $options = [])
    {
        $session = $this->requestStack->getSession();
        $token = $session?->get('jwt_token');

        if ($token) {
            $options['headers']['Authorization'] = 'Bearer ' . $token;
        }

        return $this->httpClient->request($method, $url, $options);
    }
}
