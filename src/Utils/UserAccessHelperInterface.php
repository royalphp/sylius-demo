<?php

namespace App\Utils;

interface UserAccessHelperInterface
{
    final public const string SIDE_BACK = 'admin';
    final public const string SIDE_FRONT = 'shop';

    public function isAdminUser(): bool;

    public function isShopUser(): bool;

    public function isAdminPage(): bool;

    public function isShopPage(): bool;
}
