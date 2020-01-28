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
                    'CDD' => 'cdd',
                    'CDI' => 'cdi',
                    'Stage' => 'stage',
                    'Alternance' => 'alternance',
                ],
            ])
            ->add('domain', ChoiceType::class, [
                'choices'  => [
                    'Informatique' => 'informatique',
                    'Management' => 'management',
                    'Recrutement' => 'recrutement',
                ],
            ])
            ->add('subway', ChoiceType::class, [
                'choices'  => [
                    'M12 Abbesses' => 'm12_abbesses',
                    'M4 Alésia' => 'm4_alesia',
                    'M2 Anvers' => 'm2_anvers',
                    'M1 Bérault' => 'm1_berault',
                    'M9 Billancourt' => 'm9_billancourt',
                    'M8 Chemin-Vert' => 'm8_chemin_vert'
                ],
            ])
            ->add('description')
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
