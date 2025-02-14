<?php

namespace App\Form;

use App\Descriptor\OrderIssuesDescriptor;
use App\Entity\Issue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IssueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cause', ChoiceType::class, array(
                'label' => 'Cause:',
                'placeholder' => 'Select the cause of this issue:',
                'required' => true,
                'attr' => array('class' => 'form-control'),
                'choices' => OrderIssuesDescriptor::getStatusList(),
            ))
            ->add('message', TextareaType::class, array(
                'label' => 'Description:',
                'required' => true,
                'attr' => array('class' => 'form-control'),
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Issue::class,
        ]);
    }
}
