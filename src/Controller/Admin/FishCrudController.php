<?php

namespace App\Controller\Admin;

use App\Entity\Fish;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FishCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Fish::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            TextField::new('name','Nom'),
            TextField::new('latinName','Nom latin'),
            TextEditorField::new('description', 'Description'),
            IntegerField::new('adultSize', 'Taille adulte'),
            IntegerField::new('minTemp', '°C min'),
            IntegerField::new('maxTemp', '°C max'),
            NumberField::new('minPh', 'pH min')->setNumDecimals(1),
            NumberField::new('maxPh', 'pH max')->setNumDecimals(1),
            IntegerField::new('minGh', 'Gh min'),
            IntegerField::new('maxGh', 'Gh max'),

            AssociationField::new('family', 'Famille')->autocomplete(),
            AssociationField::new('origin', 'Origine')->autocomplete(),
        ];
    }
    
}
