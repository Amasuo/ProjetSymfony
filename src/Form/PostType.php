<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title')
        ->add('description')

        //->add('Send', SubmitType::class)


           /* ->add('title', TextType::class,[
              'attr' => [
                'placeholder' => 'Title',
                'class' => 'custom_class'
              ]
            ])
            ->add('description', TextareaType::class,[
              'attr' => [
                'placeholder' => 'Description',
                ]
              ])

            ->add('Make', SubmitType::class,[
              'attr' => [
                'class' => 'btn_2',
                ]
              ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
