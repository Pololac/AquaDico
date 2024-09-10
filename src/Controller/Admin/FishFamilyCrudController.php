<?php

namespace App\Controller\Admin;

use App\Entity\FishFamily;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FishFamilyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FishFamily::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');

        // SlugField permet de générer un slug automatiquement basé sur la propriété "name" rentré par l'utilisateur
        yield SlugField::new('slug', 'Slug')
            ->setTargetFieldName('name');
    }

}
