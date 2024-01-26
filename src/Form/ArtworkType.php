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
use Vich\UploaderBundle\Form\Type\VichFileType;

class ArtworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('height', TextType::class, [
                'label' => 'Hauteur en cm',
            ])
            ->add('width', TextType::class, [
                'label' => 'Largeur en cm',
            ])
            ->add('technique', TextType::class, [
                'label' => 'Technique',
                ])
            ->add('posterFile', VichFileType::class, [
                'required' => false,
                'label' => 'Image',
                'allow_delete' => false,
                'download_uri' => false,
                ])
            ->add('description', TextType::class, [
                'label' => 'Description',
            ])
            ->add('createdAt', DateType::class, [
                'label' => 'Date de création',
                'years' => range(date('Y'), date('Y') - 50),
                'format' => 'dd-MM-yyyy',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
                'label' => 'Utilisateur',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
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
