<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RoomAddForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'room_name',
                TextType::class,
                [
                    'label' => false,
                    'attr' => [
                        'class' => 'form-control input-lg',
                        'placeholder' => 'Name of room',
                    ],
                ]
            )

            ->add(
                'room_description',
                TextareaType::class,
                [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control input-lg',
                        'placeholder' => 'description of room',
                    ],
                ]
            )

            ->add(
                'flag_add_password',
                CheckboxType::class,
                [
                    'label' => 'enable password security',
                    'required' => false,
                    'attr' => [
                        'checked' => 'checked',
                    ],
                ]
            )
            ->add(
                'password',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'label' => false,
                    'required' => false,
                    'first_options' => ['label' => 'Password'],
                    'second_options' => ['label' => 'Repeat password'],
                ]
            )
            ->add(
                'create',
                SubmitType::class,
                [
                    'label' => 'Create new room',
                    'attr' => [
                        'class' => 'btn btn-default',
                    ],
                ]
            )
        ;
    }
}