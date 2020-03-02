<?php

namespace App\Form;

use App\Entity\Barman;
use App\Entity\Bestelling;
use App\Entity\MenuItem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuBestellingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('menu_item', EntityType::class, [
                'class' => MenuItem::class,
                'choice_label' => 'naam',
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('barman', EntityType::class, [
                'class' => Barman::class,
                'choice_label' => 'drank',
                'multiple' => false,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bestelling::class,
        ]);
    }
}
