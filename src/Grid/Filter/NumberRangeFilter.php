<?php

namespace App\Grid\Filter;

use App\Grid\Filter\Form\NumberRangeFilterType;
use Sylius\Bundle\GridBundle\Doctrine\DataSourceInterface as DoctrineDataSourceInterface;
use Sylius\Component\Grid\Data\DataSourceInterface;
use Sylius\Component\Grid\Filtering\ConfigurableFilterInterface;

final readonly class NumberRangeFilter implements ConfigurableFilterInterface
{
    /**
     * @param DoctrineDataSourceInterface&DataSourceInterface $dataSource
     * @param array{from: string, to: string} $data
     * @param array<array-key, mixed> $options
     */
    public function apply(DataSourceInterface $dataSource, string $name, $data, array $options): void
    {
        $from = $data['from'] ?? '';
        $to = $data['to'] ?? '';

        if (!$from && !$to) {
            return;
        }

        $qb = $dataSource->getQueryBuilder();
        [$alias] = $qb->getRootAliases();
        $fieldName = $alias.'.'.$name;

        if ($from && $to) {
            $qb
                ->andWhere($qb->expr()->between($fieldName, ':from', ':to'))
                ->setParameters(['from' => $from, 'to' => $to])
            ;
        } elseif ($from) {
            $qb
                ->andWhere($qb->expr()->gte($fieldName, ':from'))
                ->setParameters(['from' => $from])
            ;
        } elseif ($to) {
            $qb
                ->andWhere($qb->expr()->lte($fieldName, ':to'))
                ->setParameters(['to' => $to])
            ;
        }
    }

    public static function getFormType(): string
    {
        return NumberRangeFilterType::class;
    }

    public static function getType(): string
    {
        return 'number_range';
    }
}
