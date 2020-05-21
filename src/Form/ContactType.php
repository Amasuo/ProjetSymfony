<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject',TextType::class,[
              'attr'=>[
                'placeholder' => 'Enter Subject',
                'class' => 'form-control'
              ]
            ])
            ->add('body',TextareaType::class,[
              'attr'=>[
                'placeholder' => 'Enter Message',
                'class' => 'form-control w-100',
                'cols' => '30',
                'rows' => '9'
              ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
