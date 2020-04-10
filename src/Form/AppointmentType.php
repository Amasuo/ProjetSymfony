<?php

namespace App\Form;

use App\Entity\Appointment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('date', DateTimeType::class, [
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                    'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
                ]
            ])
            ->add('service',EntityType::class, [
                'class' => 'App\Entity\Speciality',
                'placeholder'   => 'Select Service',
                'mapped'=>false,
            ])
            //->add('Send', SubmitType::class)
            ;
        $builder->get('service')->addEventListener(
                FormEvents::POST_SUBMIT,
                function(FormEvent $event)
                {   //dump($event->getForm());
                    //dump($event->getData());
                    $form = $event->getForm();
                    dump($form->getData());
                    //$data = $event->getData();
                    $form->getParent()->add('doctor',EntityType::class, [
                        'class' => 'App\Entity\Doctor',
                        'placeholder'   => 'Select Doctor',
                        'choices' => $form->getData()->getDoctor()
                     
                    ]);
                }
                )
                //->add('Send', SubmitType::class)
                ;     
        
    }
  

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}
