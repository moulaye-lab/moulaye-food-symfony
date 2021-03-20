<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('username'),
            TextField::new('email'),
            TextField::new('password')
            
            
            ->hideOnIndex(),

            ChoiceField::new('password')
            ->setChoices([
                'default' => '$argon2id$v=19$m=65536,t=4,p=1$d3VtQXBUMG5lanVTbjhJaQ$y6sSERNyeS1X1KuuybGXhkuWqd8C+vVGA1yXBF+Gyxk',
            
            ])
            ->autocomplete()
            ,
            ChoiceField::new('Roles')
            ->setChoices([
                'ROLE_ADMIN' => 'ROLE_ADMIN',
                'ROLE_USER' => 'ROLE_USER'
            
            ])
            ->allowMultipleChoices()
            ->autocomplete()
            ,
            ('contact'),
           
        ];
    }
   
}
