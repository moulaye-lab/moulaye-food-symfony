<?php

namespace App\Form;

use App\Entity\CategoriesMenu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriesMenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('description')
            ->add('nom'
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => '...',
                'download_label' => '...',
                'download_uri' => true,
                'image_uri' => true,
                'asset_helper' => true,
                'label' => '(JPG or PNG files)',
                'imagine_pattern'=> 'images_small'
            ])
               )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CategoriesMenu::class,
        ]);
    }
}
