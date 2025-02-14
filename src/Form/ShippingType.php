<?php

namespace App\Form;

use App\Entity\OrderShipping;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShippingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('company', TextType::class, array('label' => 'Company:', 'required' => true, 'attr' => array('placeholder' => 'Inform the company that will handle the shipping', 'class' => 'form-control')))
            ->add('trackingNumber', TextType::class, array('label' => 'Tracking number:', 'required' => true, 'attr' => array('placeholder' => 'Inform the tracking number', 'class' => 'form-control')))
            ->add('shippingLabelFile', FileType::class, array('label' => 'Label file:', 'required' => true, 'attr' => array('class' => 'form-control')));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderShipping::class,
        ]);
    }
}
