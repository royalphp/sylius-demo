<?php

namespace App\Grid\Filter\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class NumberRangeFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('from', NumberType::class, [
                'required' => false,
                'label' => 'sylius.ui.from',
                'attr' => ['placeholder' => 'sylius.ui.from'],
            ])
            ->add('to', NumberType::class, [
                'required' => false,
                'label' => 'sylius.ui.to',
                'attr' => ['placeholder' => 'sylius.ui.to'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'data_class' => null,
                'from' => null,
                'to' => null,
            ])
            ->setAllowedTypes('from', ['null', 'numeric'])
            ->setAllowedTypes('to', ['null', 'numeric'])
        ;
    }
}
