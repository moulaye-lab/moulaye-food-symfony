<?php

namespace App\Form;

use App\Entity\Ctables;
use App\Entity\Options;
use App\Entity\PropertySearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbreTables',IntegerType::class,[
                'required' =>true,
                'label' => "Entrez le nombre de tables à ajouter à votre restaurant",
                'attr' => [
                    'placeholder' => 'nombre de tables'
                ]
            ] )
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ctables::class,
            'method' => 'get' ,
            'csrf_protection' =>false
        ]);
    }

    public function getBlockPrefix() //pour changer ce qui affiche dans les get de lurl

    {
         return '';
    }
}
