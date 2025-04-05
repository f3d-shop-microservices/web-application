<?php declare(strict_types=1);

namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;

class JwtUser implements UserInterface
{
    public function __construct(
        private string $email,
        private array $roles = []
    ) {}

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials(): void {}

    public function getPassword(): ?string { return null; }

    public function getSalt(): ?string { return null; }

    public function getUsername(): string { return $this->email; } // Для Symfony <6.0
}
