<?php

namespace App\Controller\Admin;

use App\Entity\Restaurants;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RestaurantsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Restaurants::class;
    }

 
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom','nom'),
            TextEditorField::new('description','description'),
            AssociationField::new('proprietaire','proprietaire'),
            
        ];
    }
   
}
