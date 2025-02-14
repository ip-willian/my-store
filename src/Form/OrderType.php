<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('total', NumberType::class, [
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('discount', NumberType::class, [
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('address', TextType::class, [
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('addressNumber', TextType::class, [
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('postalCode', TextType::class, [
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('items', CollectionType::class, [
                'entry_type' => OrderItemType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
