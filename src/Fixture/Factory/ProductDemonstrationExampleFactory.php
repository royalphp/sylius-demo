<?php

namespace App\Fixture\Factory;

use App\Entity\Product\Product;
use App\Entity\Product\ProductDemonstration;
use App\Entity\Product\ProductDemonstrationStatus;
use Faker\Factory;
use Faker\Generator;
use Sylius\Bundle\CoreBundle\Fixture\Factory\AbstractExampleFactory;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Bundle\ProductBundle\Doctrine\ORM\ProductRepository;
use Sylius\Resource\Factory\FactoryInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ProductDemonstrationExampleFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    private Generator $faker;

    public function __construct(
        private readonly FactoryInterface $productDemonstrationFactory,
        private readonly ProductRepository $productRepository,
    ) {
        $this->faker = Factory::create();
    }

    public function create(array $options = []): ProductDemonstration
    {
        /** @var ProductDemonstration $productDemonstration */
        $productDemonstration = $this->productDemonstrationFactory->createNew();

        $productDemonstration->setTitle($this->faker->sentence());
        $productDemonstration->setDescription($this->faker->optional()->paragraph());
        $productDemonstration->setCapacity($this->faker->numberBetween(100, 999));
        $productDemonstration->setStatus($this->faker->randomElement(ProductDemonstrationStatus::cases()));

        $daysOffset = $this->faker->numberBetween(28, 84);

        $productDemonstration->setCreatedAt(\DateTimeImmutable::createFromMutable(
            $this->faker->dateTimeBetween(sprintf('-%d days', $daysOffset))
        ));

        if ($productDemonstration->getStatus() === ProductDemonstrationStatus::Completed) {
            $productDemonstration->setCompletedAt(\DateTimeImmutable::createFromMutable(
                $this->faker->dateTimeBetween('now', sprintf('+%d days', $daysOffset))
            ));
        }

        if ($products = $this->productRepository->findAll()) {
            $productDemonstration->setProduct($this->faker->randomElement($products));
        }

        return $productDemonstration;
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'title' => null,
            'description' => null,
            'capacity' => null,
            'featured' => null,
            'status' => null,
            'created_at' => null,
            'completed_at' => null,
            'product' => null,
        ]);

        $resolver->setAllowedTypes('title', ['null', 'string']);
        $resolver->setAllowedTypes('description', ['null', 'string']);
        $resolver->setAllowedTypes('capacity', ['null', 'int']);
        $resolver->setAllowedTypes('featured', ['null', 'bool']);
        $resolver->setAllowedTypes('status', ['null', ProductDemonstrationStatus::class, 'string']);
        $resolver->setAllowedTypes('created_at', ['null', \DateTimeImmutable::class, 'string']);
        $resolver->setAllowedTypes('completed_at', ['null', \DateTimeImmutable::class, 'string']);
        $resolver->setAllowedTypes('product', ['null', Product::class, 'string', 'int']);

        $resolver->setNormalizer('status', function (Options $options, $value) {
            if ($value === null || $value instanceof ProductDemonstrationStatus) {
                return $value;
            }

            return ProductDemonstrationStatus::from($value);
        });

        $dateNormalizer = static function (Options $options, $value) {
            if ($value === null || $value instanceof \DateTimeImmutable) {
                return $value;
            }

            return new \DateTimeImmutable($value);
        };
        $resolver->setNormalizer('created_at', $dateNormalizer);
        $resolver->setNormalizer('completed_at', $dateNormalizer);

        $resolver->setNormalizer('capacity', static function (Options $options, $value) {
            if ($value === null) {
                return null;
            }

            if (!is_int($value) || $value <= 0) {
                throw new \InvalidArgumentException('Option "capacity" must be a positive integer.');
            }

            return $value;
        });

        $resolver->setNormalizer('product', function (Options $options, $value) {
            if ($value === null || $value instanceof Product) {
                return $value;
            }

            if (is_string($value)) {
                $product = $this->productRepository->findOneBy(['code' => $value]);
                if (null !== $product) {
                    return $product;
                }
            }

            if (is_int($value)) {
                $product = $this->productRepository->find($value);
                if (null !== $product) {
                    return $product;
                }
            }

            throw new \InvalidArgumentException('Option "product" must be a Product entity, a product code (string), or an id (int).');
        });
    }
}
