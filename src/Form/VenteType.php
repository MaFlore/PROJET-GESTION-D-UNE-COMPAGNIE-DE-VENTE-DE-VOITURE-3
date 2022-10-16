<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Vente;
use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateVente', DateType::class, [ "attr" => ["class" => "form-control"],
                    'widget' => 'single_text',
                    // this is actually the default format for single_text
                    'format' => 'yyyy-MM-dd', ])
            ->add('montant', IntegerType::class, [ "attr" => ["class" => "form-control"] ])
            ->add('voiture', EntityType::class, ['class' => Voiture::class ,
                'choice_label' => 'marque',
                'label' => 'Voiture',
                "attr" => ["class" => "form-control"],
                'query_builder'=> function(VoitureRepository $voiture){
                    return $voiture->createQueryBuilder('v')
                    ->where('v.statut = :Accessible')
                    ->setParameter('Accessible', '0');
                    }
                 ])
            ->add('client', EntityType::class, ['class' => Client::class,
                'choice_label' => function($client){
                    return $client->getNom()." ".$client->getPrenom();
                },
                'label' => 'Client',
                "attr" => ["class" => "form-control"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vente::class,
        ]);
    }
}
