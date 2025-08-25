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
                    'priority' => 8,
                ])
                ->add('capacity', options: ['priority' => 5])
                ->add('featured', options: ['priority' => 4])
                ->add('status', EnumType::class, [
                    'class' => ProductDemonstrationStatus::class,
                    'priority' => 3,
                ])
                ->add('completedAt', options: [
                    'widget' => 'single_text',
                    'priority' => 1,
                ])
                ->add('createdAt', options: [
                    'widget' => 'single_text',
                    'priority' => 2,
                ])
            ;
        }

        $builder
            ->add('title', options: ['priority' => 7])
            ->add('description', options: ['priority' => 6])
        ;
    }
}
