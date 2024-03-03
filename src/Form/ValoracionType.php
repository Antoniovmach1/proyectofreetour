<?php

namespace App\Form;

use App\Entity\Valoracion;
use App\Entity\reserva;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ValoracionType extends AbstractType
{ 
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('valoracion_guia', ChoiceType::class, [
            'choices' => [
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
            ],
            'expanded' => true,
            // 'multiple' => false,
            // 'label' => 'Valoración de la guía',
            // 'attr' => [
            //     'class' => 'dynamic-rating'
            // ]
        ])

        ->add('valoracion_Ruta', ChoiceType::class, [
            'choices' => [
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
            ],
            'expanded' => true, 
        ])
            ->add('comentario')
   
        ;
    }

    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Valoracion::class,
        ]);
    }
}
