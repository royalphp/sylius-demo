<?php

namespace App\Grid;

use App\Entity\Product\Product;
use App\Entity\Product\ProductDemonstration;
use App\Entity\Product\ProductDemonstrationStatus;
use App\Utils\GridHelperInterface;
use Sylius\Bundle\GridBundle\Builder\Action\Action;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\BulkActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\MainActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\DateTimeField;
use Sylius\Bundle\GridBundle\Builder\Field\Field;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Field\TwigField;
use Sylius\Bundle\GridBundle\Builder\Filter\Filter;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;

final class ProductDemonstrationGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    public function __construct(
        private readonly GridHelperInterface $gridHelper,
    ) {
    }

    public static function getName(): string
    {
        return 'app_product_demonstration';
    }

    public function getResourceClass(): string
    {
        return ProductDemonstration::class;
    }

    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->addFilter(Filter::create('product', 'entity')
                ->setFormOptions(['class' => Product::class])
                ->setLabel('sylius.ui.product')
                ->setTemplate($this->gridHelper->getTemplateByTheme(GridHelperInterface::GRID_FILTER, 'entity'))
                ->setEnabled($this->gridHelper->getUserAccessHelper()->isAdminUser())
            )
            ->addFilter(Filter::create('title', 'string')
                ->setLabel('sylius.ui.title')
                ->setTemplate($this->gridHelper->getTemplateByTheme(GridHelperInterface::GRID_FILTER, 'string'))
            )
            ->addFilter(Filter::create('capacity', 'number_range')
                ->setLabel('app.ui.capacity')
                ->setTemplate($this->gridHelper->getTemplateByTheme(GridHelperInterface::GRID_FILTER, 'number_range'))
            )
            ->addFilter(Filter::create('createdAt', 'date')
                ->setLabel('sylius.ui.created_at')
                ->setTemplate($this->gridHelper->getTemplateByTheme(GridHelperInterface::GRID_FILTER, 'date'))
            )
            ->addFilter(Filter::create('featured', 'boolean')
                ->setLabel('app.ui.featured')
                ->setTemplate($this->gridHelper->getTemplateByTheme(GridHelperInterface::GRID_FILTER, 'boolean'))
            )
            ->addFilter(Filter::create('status', 'select')
                ->setLabel('sylius.ui.status')
                ->setFormOptions(['choices' => array_combine(
                    array_map(static fn (string $status): string => ProductDemonstrationStatus::TRANS_KEY.'.'.$status, ProductDemonstrationStatus::toArray()),
                    ProductDemonstrationStatus::toArray(),
                )])
                ->setTemplate($this->gridHelper->getTemplateByTheme(GridHelperInterface::GRID_FILTER, 'select'))
            )

            ->addField(StringField::create('product')
                ->setLabel('sylius.ui.product')
                ->setSortable(true)
                ->setEnabled($this->gridHelper->getUserAccessHelper()->isAdminUser())
            )
            ->addField(Field::create('title', 'string')
                ->setLabel('sylius.ui.title')
                ->setSortable(true)
            )
            ->addField(StringField::create('description')
                ->setLabel('sylius.ui.description')
                ->setEnabled($this->gridHelper->getUserAccessHelper()->isAdminPage())
            )
            ->addField(TwigField::create('capacity', $this->gridHelper->getTemplateByTheme(GridHelperInterface::GRID_FIELD, 'numeric_value'))
                ->setLabel('app.ui.capacity')
                ->setSortable(true)
            )
            ->addField(TwigField::create('featured', $this->gridHelper->getTemplateByTheme(GridHelperInterface::GRID_FIELD, 'yesNo'))
                ->setLabel('app.ui.featured')
                ->setSortable(true)
            )
            ->addField(TwigField::create('status', $this->gridHelper->getTemplateByTheme(GridHelperInterface::GRID_FIELD, 'enum_label'))
                ->setLabel('sylius.ui.status')
                ->setSortable(true)
            )
            ->addField(DateTimeField::create('createdAt')
                ->setLabel('sylius.ui.created_at')
                ->setSortable(true)
            )
            ->addField(DateTimeField::create('completedAt')
                ->setLabel('app.ui.completed_at')
                ->setSortable(true)
                ->setEnabled($this->gridHelper->getUserAccessHelper()->isAdminUser())
            )

            ->addActionGroup(MainActionGroup::create(
                Action::create('create', $this->gridHelper->getTemplateByTheme(GridHelperInterface::GRID_ACTION, 'create'))
                    ->setEnabled($this->gridHelper->getUserAccessHelper()->isAdminUser()),
            ))
            ->addActionGroup(ItemActionGroup::create(
                Action::create('show', $this->gridHelper->getTemplateByTheme(GridHelperInterface::GRID_ACTION, 'show'))
                    ->setEnabled($this->gridHelper->getUserAccessHelper()->isShopUser()),
                Action::create('update', $this->gridHelper->getTemplateByTheme(GridHelperInterface::GRID_ACTION, 'update')),
                Action::create('toggle-featured', $this->gridHelper->getTemplateByTheme(GridHelperInterface::GRID_ACTION, 'toggle_featured'))
                    ->setLabel('app.ui.toggle_featured')
                    ->setEnabled($this->gridHelper->getUserAccessHelper()->isShopUser())
                    ->setOptions(['link' => [
                        'route' => 'app_shop_account_product_demonstration_toggle_featured',
                        'parameters' => ['id' => 'resource.id'],
                    ]]),
                Action::create('delete', $this->gridHelper->getTemplateByTheme(GridHelperInterface::GRID_ACTION, 'delete'))
                    ->setEnabled($this->gridHelper->getUserAccessHelper()->isAdminUser()),
            ))
            ->addActionGroup(BulkActionGroup::create(
                Action::create('delete', $this->gridHelper->getTemplateByTheme(GridHelperInterface::GRID_ACTION, 'delete'))
                    ->setEnabled($this->gridHelper->getUserAccessHelper()->isAdminUser()),
            ))

            ->addOrderBy('createdAt')
            ->setLimits([8, 16, 32, 64])
        ;
    }
}
