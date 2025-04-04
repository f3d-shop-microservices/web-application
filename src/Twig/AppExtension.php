<?php declare(strict_types=1);

namespace App\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

final class AppExtension extends AbstractExtension implements GlobalsInterface{
    public function __construct(private RequestStack $requestStack) {}

    public function getGlobals(): array
    {
        $session = $this->requestStack->getSession();

        return [
            'isAuthenticated' => $session?->has('jwt_token'),
        ];
    }
}