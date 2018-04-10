<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', TextType::class, [
                'label' => false,
                'attr' => array(
                    'class'         => 'form-control input-lg',
                    'placeholder'   => 'Username',
                )
            ])

            ->add('_password', PasswordType::class, [
                'label' => false,
                'attr' => array(
                    'class'         => 'form-control input-lg',
                    'placeholder'   => 'Password',
                )
            ])
        ;
    }
}