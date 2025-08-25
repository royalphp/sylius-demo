<?php

namespace App\Fixture;

use App\Entity\Product\ProductDemonstrationStatus;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\CoreBundle\Fixture\AbstractResourceFixture;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

final class ProductDemonstrationFixture extends AbstractResourceFixture
{
    public function __construct(
        readonly EntityManagerInterface $entityManager,
        readonly ExampleFactoryInterface $productDemonstrationExampleFactory,
    ) {
        parent::__construct($entityManager, $productDemonstrationExampleFactory);
    }

    public function getName(): string
    {
        return 'product_demonstration';
    }

    protected function configureResourceNode(ArrayNodeDefinition $resourceNode): void
    {
        $resourceNode
            ->children()
                ->scalarNode('title')->defaultNull()->end()
                ->scalarNode('description')->defaultNull()->end()
                ->integerNode('capacity')->defaultNull()->min(1)->end()
                ->booleanNode('featured')->defaultNull()->end()
                ->scalarNode('status')
                    ->defaultNull()
                        ->validate()
                        ->ifTrue(static function (mixed $value): bool {
                            return $value !== null && !in_array($value, ProductDemonstrationStatus::toArray(), true);
                        })
                        ->thenInvalid(sprintf(
                            'Invalid "status". Allowed values: %s',
                            implode(', ', ProductDemonstrationStatus::toArray())
                        ))
                    ->end()
                ->end()
                ->scalarNode('created_at')
                    ->defaultNull()
                    ->validate()
                        ->ifTrue(static function (mixed $value): bool {
                            return $value !== null && strtotime($value) === false;
                        })
                        ->thenInvalid('Option "created_at" must be a parsable datetime string or null.')
                    ->end()
                ->end()
                ->scalarNode('completed_at')
                    ->defaultNull()
                        ->validate()
                        ->ifTrue(static function (mixed $value): bool {
                            return $value !== null && strtotime($value) === false;
                        })
                        ->thenInvalid('Option "completed_at" must be a parsable datetime string or null.')
                    ->end()
                ->end()
                ->scalarNode('product')
                    ->defaultNull()
                    ->validate()
                        ->ifTrue(static function (mixed $value): bool {
                            if ($value === null) {
                                return false;
                            }

                            return is_bool($value);
                        })
                        ->thenInvalid('Option "product" must be a product code (string) or id (int).')
                    ->end()
                ->end()
            ->end()
        ;
    }
}
