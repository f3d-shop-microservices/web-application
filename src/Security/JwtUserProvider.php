<?php declare(strict_types=1);

namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class JwtUserProvider implements UserProviderInterface
{
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        throw new UserNotFoundException("Cannot load users from identifier.");
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof JwtUser) {
            throw new UnsupportedUserException('Unsupported user class.');
        }

        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return $class === JwtUser::class;
    }
}
