<?php

namespace App\Controller\Admin;

use App\Entity\CategoriesMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoriesMenuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategoriesMenu::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
