<?php

namespace App\Form;

use App\Entity\Reserva;
use App\Entity\Tour;
use App\Entity\Usuario;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cantidad')
            ->add('tour', EntityType::class, [
                'class' => Tour::class,
                'choice_label' => function ($tour) {
                    return $tour->getFechaInicio()->format('Y-m-d'); 
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->where('t.fecha_inicio > :currentDate')
                        ->setParameter('currentDate', new \DateTime())
                        ->orderBy('t.fecha_inicio', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reserva::class,
        ]);
    }
}