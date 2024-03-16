<?php

namespace App\Form;

use App\Entity\CategorieBudget;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Budget;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CategorieBudgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomCategorie')
            ->add('budget', EntityType::class, [
                'class' => Budget::class,
                'choice_label' => 'nomCategorie',
            ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategorieBudget::class,
        ]);
    }
}
