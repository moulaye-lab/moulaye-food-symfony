<?php

namespace App\Form;

use App\Entity\PlatMenu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddPlatMenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('imageFile', VichImageType::class, [
            'required' => false,
            'allow_delete' => true,
            'delete_label' => '...',
            'download_label' => '...',
            'download_uri' => true,
            'image_uri' => true,
            'asset_helper' => true,
            'label' => '(JPG or PNG files)',
        ])
            ->add('nom')
            ->add('description')
            ->add('prix')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PlatMenu::class,
        ]);
    }
}
