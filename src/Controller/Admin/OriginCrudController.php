<?php

namespace App\Controller\Admin;

use App\Entity\Origin;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OriginCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Origin::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('continent');

        // SlugField permet de générer un slug automatiquement basé sur la propriété "continent" rentré par l'utilisateur
        yield SlugField::new('slug', 'Slug')
            ->setTargetFieldName('continent');
    }

}
