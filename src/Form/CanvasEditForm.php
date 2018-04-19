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

class CanvasEditForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'canvas_name',
                TextType::class,
                [
                    'label' => false,
                    'attr' => [
                        'class' => 'form-control input-lg',
                        'placeholder' => 'Name of canvas',
                    ],
                ]
            )

            ->add(
                'create',
                SubmitType::class,
                [
                    'label' => 'Edit canvas',
                    'attr' => [
                        'class' => 'btn btn-default',
                    ],
                ]
            )
        ;
    }
}