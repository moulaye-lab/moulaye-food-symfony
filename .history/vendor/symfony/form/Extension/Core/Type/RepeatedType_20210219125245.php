<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Form\Extension\Core\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\ValueToDuplicatesTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepeatedType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Overwrite required option for child fields
        $options['first_options']['required'] = $options['required'];
        $options['second_options']['required'] = $options['required'];

        if (!isset($options['options']['error_bubbling'])) {
            $options['options']['error_bubbling'] = $options['error_bubbling'];
        }

        // children fields must always be mapped
        $defaultOptions = ['mapped' => true];

        $builder
            ->addViewTransformer(new ValueToDuplicatesTransformer([
                $options['mot_de_passe'],
                $options['retapez'],
            ]))
            ->add($options['mot_de_passe'], $options['type'], array_merge($options['options'], $options['first_options'], $defaultOptions),[
                'label'=> "mot de passe"
            ])
            ->add($options['retapez'], $options['type'], array_merge($options['options'], $options['second_options'], $defaultOptions))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'type' => TextType::class,
            'options' => [],
            'first_options' => [],
            'second_options' => [],
            'mot_de_passe' => 'first',
            'retapez' => 'second',
            'error_bubbling' => false,
        ]);

        $resolver->setAllowedTypes('options', 'array');
        $resolver->setAllowedTypes('first_options', 'array');
        $resolver->setAllowedTypes('second_options', 'array');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'repeated';
    }
}
