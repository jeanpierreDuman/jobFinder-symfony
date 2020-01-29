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
                    'CSS' => 'CSS',
                    'PHP' => 'PHP',
                    'HTML' => 'HTML',
                    'Symfony' => 'Symfony',
                    'Django' => 'Django',
                    'Python' => 'Python',
                    'Gestion de projet' => 'Gestion de projet',
                    'Autonome' => 'Autonome',
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
