<?php

namespace App\Form;

use App\Entity\Criteria;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CriteriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', ChoiceType::class, [
                'choices'  => [
                    'CSS' => 'css',
                    'PHP' => 'php',
                    'HTML' => 'html',
                    'Symfony' => 'symfony',
                    'Django' => 'django',
                    'Python' => 'python',
                    'Gestion de projet' => 'gestion de projet',
                    'Autonome' => 'autonome',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Criteria::class,
        ]);
    }
}
