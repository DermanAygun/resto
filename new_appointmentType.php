<?php

namespace App\Form;

use App\Entity\Barber;
use App\Entity\Appointment;
use App\Entity\Customer;
use App\Entity\Treatment;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class new_appointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('barber', EntityType::class, [
                'class' => Barber::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('treatment', EntityType::class, [
                'class' => Treatment::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('time', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
            ])
            ->add('name')
            ->add('phone', TextType::class, [
                'required' => false,
                'label' => 'phone',
            ])
            ->add('email', TextType::class, [
                'required' => false,
                'label' => 'email',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

        ]);
    }
}
