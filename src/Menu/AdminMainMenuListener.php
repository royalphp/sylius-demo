<?php

namespace App\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: 'sylius.menu.admin.main', method: 'onSyliusMenuAdminMain')]
final readonly class AdminMainMenuListener
{
    public function onSyliusMenuAdminMain(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $newSubmenu = $menu
            ->addChild('header-demos')
            ->setLabel('app.menu.admin.main.demos.header')
        ;

        $newSubmenu
            ->addChild('product_demonstration', ['route' => 'app_admin_product_demonstration_index'])
            ->setLabel('app.menu.admin.main.demos.product_demonstrations')
            ->setLabelAttribute('icon', 'cube')
        ;
    }
}
