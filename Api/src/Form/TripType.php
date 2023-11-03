<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Trip;
use App\Entity\Worker;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TripType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start', DateTimeType::class, [
                'property_path' => 'dateTimeStart',
                'widget' => 'single_text',
                'by_reference' => true,
                'constraints' => [new NotBlank()],
            ])
            ->add('end', DateTimeType::class, [
                'property_path' => 'dateTimeEnd',
                'widget' => 'single_text',
                'by_reference' => true,
                'constraints' => [new NotBlank()],
            ])
            ->add('worker', EntityType::class, [
                'class' => Worker::class,
                'constraints' => [new NotBlank()]
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'constraints' => [new NotBlank()]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trip::class,
        ]);
    }
}
