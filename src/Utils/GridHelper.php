<?php

namespace App\Utils;

final readonly class GridHelper implements GridHelperInterface
{
    public function __construct(
        private UserAccessHelperInterface $userAccessHelper,
        private UserThemeHelperInterface $userThemeHelper,
    ) {
    }

    public function getUserAccessHelper(): UserAccessHelperInterface
    {
        return $this->userAccessHelper;
    }

    public function getUserThemeHelper(): UserThemeHelperInterface
    {
        return $this->userThemeHelper;
    }

    public function getTemplateByTheme(string $type, string $name): string
    {
        if (!in_array($type, GridHelperInterface::GRID_PARTS, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid grid part "%s"', $type));
        }

        if (GridHelperInterface::GRID_ACTION === $type) {
            return $this->isShopPageOfBootstrapTheme() ? 'theme.bootstrap.' . $name : $name;
        }

        return sprintf(
            '@Sylius%s/Grid/%s/%s.html.twig',
            $this->isShopPageOfBootstrapTheme() ? 'Shop' : 'Ui',
            ucfirst($type),
            $name,
        );
    }

    private function isShopPageOfBootstrapTheme(): bool
    {
        return $this->getUserAccessHelper()->isShopPage() && $this->getUserThemeHelper()->isBootstrapTheme();
    }
}
