<?php

namespace App\Form;

use App\Entity\Job;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

class SearchJobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'CDD' => 'CDD',
                    'CDI' => 'CDI',
                    'Stage' => 'Stage',
                    'Alternance' => 'Alternance',
                ],
                'mapped' => false,
                'required' => false,
                'placeholder' => 'Choisir le type',
            ])
            ->add('domain', ChoiceType::class, [
                'choices'  => [
                    'Informatique' => 'Informatique',
                    'Management' => 'Management',
                    'Recrutement' => 'Recrutement',
                ],
                'mapped' => false,
                'required' => false,
                'placeholder' => 'Choisir le thème',
            ])
            ->add('subway', ChoiceType::class, [
                'choices'  => [
                    'M12 Abbesses' => 'M12 Abbesses',
                    'M4 Alésia' => 'M4 Alésia',
                    'M2 Anvers' => 'M2 Anvers',
                    'M1 Bérault' => 'M1 Bérault',
                    'M9 Billancourt' => 'M9 Billancourt',
                    'M8 Chemin-Vert' => 'M8 Chemin-Vert'
                ],
                'placeholder' => 'Choisir un métro',
                'mapped' => false,
                'required' => false,

            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ])
            ->add('reset', ResetType::class, [
                'attr' => ['class' => 'reset'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}
