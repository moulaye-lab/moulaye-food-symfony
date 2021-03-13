<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('oldPassword', PasswordType::class, array(

            'mapped' => false

        ))

        ->add('plainPassword', RepeatedType::class, array(

            'type' => PasswordType::class,

            'invalid_message' => 'Les deux mots de passe doivent être identiques',

            'options' => array(

                'attr' => array(

                    'class' => 'password-field'

                )

            ),

            'required' => true,
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
