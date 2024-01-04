<?php

namespace App\Form;

use App\Entity\Artwork;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('height', TextType::class, [
                'label' => 'Hauteur',
            ])
            ->add('weight', TextType::class, [
                'label' => 'Largeur',
            ])
            ->add('technique', TextType::class, [
                'label' => 'Technique',
            ])
            ->add('imageCover', TextType::class, [
                'label' => 'Image',
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
            ])
            ->add('createdAt', DateType::class, [
                'label' => 'Date de création',
                'years' => range(date('Y'), date('Y') - 50),
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
                'label' => 'Utilisateur',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'id',
                'label' => 'Catégorie',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artwork::class,
        ]);
    }
}
