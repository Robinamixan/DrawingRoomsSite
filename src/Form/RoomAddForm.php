<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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
                    'attr' => [
                        'class' => 'form-control input-lg',
                        'placeholder' => 'description of room',
                    ],
                ]
            );
    }
}