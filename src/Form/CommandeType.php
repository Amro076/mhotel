<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_arrivee',DateTimeType::class, [
                'widget' => 'single_text',  // permet de choisir l'affichage d'un calendrier (voir doc datetimetype)
                'attr' => [
                    'min' => (new \DateTime())->format('Y-m-d H:i'), // permet d'empecher de choisir une date ultérieure à celle d'aujourd'hui (voir doc datetime)
                ]
                ])

            ->add('date_depart', DateTimeType::class, [
                'widget' => 'single_text',  // permet de choisir l'affichage d'un calendrier (voir doc datetimetype)
                'attr' => [
                    'min' => (new \DateTime())->format('Y-m-d H:i'), // permet d'empecher de choisir une date ultérieure à celle d'aujourd'hui (voir doc datetime)
                ]
            ])

            //->add('prix_total')
            ->add('prenom')
            ->add('nom')
            ->add('telephone')
            ->add('email')
            //->add('createdAt')
            //->add('chambre')
        ;
        $builder->add('Reserver', SubmitType::class, [
            'attr' => ['class' => 'save', 'formmethod'=>"post"
        ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
