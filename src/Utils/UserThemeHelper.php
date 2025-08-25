<?php

namespace App\Utils;

use Sylius\Bundle\ThemeBundle\Context\ThemeContextInterface;

final readonly class UserThemeHelper implements UserThemeHelperInterface
{
    public function __construct(
        private ThemeContextInterface $themeContext,
    ) {
    }

    public function isBootstrapTheme(string $keyword = 'bootstrap'): bool
    {
        return str_contains($this->themeContext->getTheme()?->getName() ?? '', $keyword);
    }
}
