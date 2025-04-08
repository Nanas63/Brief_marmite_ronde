<?php

namespace App\Form;

use Dom\Entity;
use App\Entity\Recipe;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom de la recette',
                'required' => true,
                'attr' => ['placeholder' => 'Entrez le nom de la recette'],
            ])
            ->add('content', TextType::class, [
                'label' => 'Description',
                'required' => true,
                'attr' => ['placeholder' => 'Entrez la description de la recette'],
            ])
            ->add('image', TextType::class, [
                'label' => 'Lien de l\'image',
                'required' => true,
                'attr' => ['placeholder' => 'Entrez l\'URL de l\'image'],
            ])
            ->add('duration', TextType::class, [
                'label' => 'Duree',
                'required' => true,
                'attr' => ['placeholder' => 'Entrez la durée de préparation'],
            ])
            ->add('Category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Niveau de difficulté',
                'required' => true,
                'attr' => ['placeholder' => 'Entrez le niveau de difficulté'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => Recipe::class,
        ]);
    }
}
