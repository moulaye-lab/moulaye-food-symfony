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

    private $mdp="$argon2id$v=19$m=65536,t=4,p=1$T1FEOEZ0RjR1UFFxblBPSA$dPNAunDUu2xP53fnvQ07zOlM5TjcGahXoaiQ58Aplvc";

    public function __construct($mdp)
    {
        $this->mdp =$mdp;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('username'),
            TextField::new('email'),
            TextField::new('password')
            
            /*->hideOnIndex()*/,
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
