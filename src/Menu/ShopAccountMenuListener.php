<?php

namespace App\Menu;

use App\Utils\UserThemeHelperInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: 'sylius.menu.shop.account', method: 'onSyliusMenuShopAccount')]
final readonly class ShopAccountMenuListener
{
    public function __construct(
        private UserThemeHelperInterface $userThemeHelper,
    ) {
    }

    public function onSyliusMenuShopAccount(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        if ($this->userThemeHelper->isBootstrapTheme()) {
            $menu->getChild('dashboard')?->setLabelAttribute('icon', 'house');
            $menu->getChild('personal_information')?->setLabelAttribute('icon', 'person');
        }

        $menu
            ->addChild('product_demonstration', ['route' => 'app_shop_account_product_demonstration_index'])
            ->setLabel('app.menu.shop.account.demos.product_demonstrations')
            ->setLabelAttribute('icon', $this->userThemeHelper->isBootstrapTheme() ? 'box' : 'cube')
        ;
    }
}
