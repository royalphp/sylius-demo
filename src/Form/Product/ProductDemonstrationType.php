<?php

namespace App\Form\Product;

use App\Entity\Product\Product;
use App\Entity\Product\ProductDemonstrationStatus;
use App\Utils\UserAccessHelperInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductDemonstrationType extends AbstractResourceType
{
    public function __construct(
        private readonly UserAccessHelperInterface $userAccessHelper,
        string $dataClass,
        array $validationGroups,
    ) {
        parent::__construct($dataClass, $validationGroups);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($this->userAccessHelper->isAdminUser()) {
            $builder
                ->add('product', EntityType::class, [
                    'class' => Product::class,
                    'label' => 'sylius.ui.product',
                    'priority' => 8,
                ])
                ->add('capacity', options: [
                    'label' => 'app.ui.capacity',
                    'priority' => 5,
                ])
                ->add('featured', options: [
                    'label' => 'app.ui.featured',
                    'priority' => 4,
                ])
                ->add('status', EnumType::class, [
                    'class' => ProductDemonstrationStatus::class,
                    'label' => 'sylius.ui.status',
                    'priority' => 3,
                ])
                ->add('completedAt', options: [
                    'label' => 'app.ui.completed_at',
                    'widget' => 'single_text',
                    'priority' => 1,
                ])
                ->add('createdAt', options: [
                    'label' => 'sylius.ui.created_at',
                    'widget' => 'single_text',
                    'priority' => 2,
                ])
            ;
        }

        $builder
            ->add('title', options: [
                'label' => 'sylius.ui.title',
                'priority' => 7,
            ])
            ->add('description', options: [
                'label' => 'sylius.ui.description',
                'priority' => 6,
            ])
        ;
    }
}
