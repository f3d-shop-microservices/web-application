<?php declare(strict_types=1);

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class ApiUrlBuilder {
    public function __construct(
        #[Autowire('%env(string:NGINX_SVC_HOST)%')]
        private readonly string $nginxSvcHost,

        #[Autowire('%env(string:API_VERSION_PREFIX)%')]
        private readonly string $apiVersionPrefix,
    ) {}

    public function build(string $path): string
    {
        $normalizedPath = ltrim($path, '/');

        return sprintf(
            'https://%s/%s/%s',
            $this->nginxSvcHost,
            trim($this->apiVersionPrefix, '/'),
            $normalizedPath
        );
    }
}