<?php

namespace App\Form;

use App\Entity\Reserva;
use App\Entity\Tour;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class ReservaType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $em = $this->entityManager;

        $rutaId = $options['attr']['rutaId'];

        $aforo = $this->entityManager->createQueryBuilder()
            ->select('r.aforo')
            ->from('App\Entity\Ruta', 'r')
            ->where('r.id = :rutaId')
            ->setParameter('rutaId', $rutaId)
            ->getQuery()
            ->getSingleScalarResult();

        $totalCantidad = 1;

        $builder
            ->add('cantidad', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Range([
                        'min' => 1,
                        'max' => $aforo - $totalCantidad,
                        'notInRangeMessage' => $aforo >= $totalCantidad
                            ? 'La cantidad debe estar entre {{ min }} y {{ max }}.'
                            : 'No hay más entradas disponibles.',
                    ]),
                ],
            ])
            ->add('tour', EntityType::class, [
                'class' => Tour::class,
                'choice_label' => function ($tour) {
                    return $tour->getFechaInicio()->format('Y-m-d');
                },
               
                    'query_builder' => function (EntityRepository $er) use ($rutaId) {
                        return $er->createQueryBuilder('t')
                        ->where('t.fecha_inicio > :currentDate')
                        ->andWhere('t.Ruta = :rutaId') // Utilizando la propiedad directa Ruta
                        ->setParameter('currentDate', new \DateTime())
                        ->setParameter('rutaId', $rutaId); // ID de la ruta deseada
                        // ->orderBy('t.fecha_inicio', 'ASC');
                },
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);

        // $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
        //     $form = $event->getForm();
        //     $tour = $form->get('tour')->getData();

        //     $tourId = $tour->getId();

            
        //     $aforo = $this->entityManager->createQueryBuilder()
        //         ->select('r.aforo')
        //         ->from('App\Entity\Ruta', 'r')
        //         ->where('r.id = :rutaId')
        //         ->setParameter('rutaId', $form->getConfig()->getOption('attr')['rutaId'])
        //         ->getQuery()
        //         ->getSingleScalarResult();

          
        //     //  $totalCantidad = 5;
        //      $totalCantidad = $this->entityManager->createQueryBuilder()
        //      ->select('COALESCE(SUM(r.cantidad), 0) as total_cantidad')
        //      ->from('App\Entity\Reserva', 'r')
        //      ->where('r.Tour = :tourId')  // Utiliza 'Tour' según el nombre de tu propiedad en la entidad Reserva
        //      ->setParameter('tourId',$tourId) // Asegúrate de proporcionar un valor válido para $tourId
        //      ->getQuery()
        //      ->getSingleScalarResult();
        //     $form->get('cantidad')->getConfig()->getOption('constraints')[0]->max = $aforo - $totalCantidad;
        // });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reserva::class,
        ]);
    }
}