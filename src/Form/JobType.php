<?php

namespace App\Form;

use App\Entity\Job;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\CriteriaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'CDD' => 'CDD',
                    'CDI' => 'CDI',
                    'Stage' => 'Stage',
                    'Alternance' => 'Alternance',
                ],
            ])
            ->add('limitApply', null, [
                'label' => "Limite de candidature"
            ])
            ->add('domain', ChoiceType::class, [
                'choices'  => [
                    'Informatique' => 'Informatique',
                    'Management' => 'Management',
                    'Recrutement' => 'Recrutement',
                ],
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
            ])
            ->add('description')
            ->add('conditions', ChoiceType::class, [
                'choices' => [
                    'CV' => 'CV',
                    'Lettre de motivation' => 'MOTIVATION',
                    'Expérience profesionnelle' => 'XP',
                    'Etudes' => 'ETUDE'
                ],
                'multiple' => true,
                'expanded'  => true
            ])
            ->add('criterias', CollectionType::class, [
                'entry_type' => CriteriaType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
