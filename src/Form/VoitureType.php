<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque',TextType::class, [ "attr" => ["class" => "form-control"] ])
            ->add('modele',TextType::class, [ "attr" => ["class" => "form-control"] ])
            ->add('numeroIdentifiant',TextType::class, [ "attr" => ["class" => "form-control"] ])
            ->add('numeroSerie',TextType::class, [ "attr" => ["class" => "form-control"] ])
            ->add('dateAchat',DateType::class, [ "attr" => ["class" => "form-control"],
                    'widget' => 'single_text',
                    // this is actually the default format for single_text
                    'format' => 'yyyy-MM-dd',
             ])
            ->add('couleur',TextType::class, [ "attr" => ["class" => "form-control"] ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
