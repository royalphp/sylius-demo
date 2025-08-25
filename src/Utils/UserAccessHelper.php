<?php

namespace App\Utils;

use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final readonly class UserAccessHelper implements UserAccessHelperInterface
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
    ) {
    }

    public function isAdminUser(): bool
    {
        return $this->getCurrentUser() instanceof AdminUserInterface;
    }

    public function isShopUser(): bool
    {
        return $this->getCurrentUser() instanceof ShopUserInterface;
    }

    public function isAdminPage(): bool
    {
        return $this->isSidePage(self::SIDE_BACK);
    }

    public function isShopPage(): bool
    {
        return $this->isSidePage(self::SIDE_FRONT);
    }

    private function getCurrentUser(): UserInterface
    {
        $user = $this->tokenStorage->getToken()?->getUser();

        if (!($user instanceof UserInterface)) {
            throw new AccessDeniedException();
        }

        return $user;
    }

    private function isSidePage(string $side): bool
    {
        $token = $this->tokenStorage->getToken();

        if (!($token instanceof UsernamePasswordToken)) {
            throw new AccessDeniedException();
        }

        return $side === $token->getFirewallName();
    }
}
