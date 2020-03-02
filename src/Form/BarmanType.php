<?php

namespace App\Form;

use App\Entity\Barman;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BarmanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('drank_naam')
            ->add('prijs')
            ->add('beschrijving')
            ->add('alcohol')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Barman::class,
        ]);
    }
}
