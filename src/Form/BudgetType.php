<?php

namespace App\Form;

use App\Entity\Budget;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType; // Add this line



class BudgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant')
           
            ->add('newCategorie', TextType::class, [
                    'mapped' => false, // This field is not mapped to any entity property
                    'label' => 'Categorie', // Customize the label as needed
                    'required' => false, // Allow an empty input
                ]);
            }
        
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Budget::class,
            'categories' => [], // Default value for the 'categories' option
        ]);
    }
}