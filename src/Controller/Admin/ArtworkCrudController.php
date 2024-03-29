<?php

namespace App\Controller\Admin;

use App\Entity\Artwork;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArtworkCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Artwork::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('description'),
            ImageField::new('imagecover')
                ->setBasePath('uploads/images/posters') // the base path to view the file
                ->setUploadDir('public/uploads/images/posters') // the upload directory
                ->setUploadedFileNamePattern('[randomhash].[extension]') // file name pattern
                ->setRequired(false),AssociationField::new('user')
                ->setCrudController(UserCrudController::class),        ];
    }
}
