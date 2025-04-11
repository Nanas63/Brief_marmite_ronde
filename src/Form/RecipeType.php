<?php

namespace App\Form;

use Dom\Entity;
use App\Entity\Recipe;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
                'attr' => ['placeholder' => 'Nom de la recette'],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
                'attr' => ['placeholder' => 'Description de la recette'],
            ])
            ->add('image', TextType::class, [
                'label' => 'Lien de l\'image',
                'required' => true,
                'attr' => ['placeholder' => 'URL de l\'image'],
            ])
            ->add('duration', TextType::class, [
                'label' => 'Duree',
                'required' => true,
                'attr' => ['placeholder' => 'Durée de la recette en minutes'],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'Level',
                'label' => 'Niveau de difficulté',
                'required' => true,
                'attr' => ['placeholder' => 'Niveau de difficulté'],
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
