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
        yield IdField::new('id');
        yield TextField::new('name','Nom');
        yield TextField::new('latinName','Nom latin');
        yield TextEditorField::new('description', 'Description');
        yield IntegerField::new('adultSize', 'Taille adulte');
        yield IntegerField::new('minTemp', '°C min');
        yield IntegerField::new('maxTemp', '°C max');
        yield NumberField::new('minPh', 'pH min')->setNumDecimals(1);
        yield NumberField::new('maxPh', 'pH max')->setNumDecimals(1);
        yield IntegerField::new('minGh', 'Gh min');
        yield IntegerField::new('maxGh', 'Gh max');

        yield AssociationField::new('family', 'Famille')->autocomplete();
        yield AssociationField::new('origin', 'Origine')->autocomplete();

        yield BooleanField::new('isVisible', 'Visible');
    }
}
