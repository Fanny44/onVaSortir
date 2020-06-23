<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('dateHeureDebut', DateTimeType::class)
            ->add('duree', IntegerType::class)
            ->add('dateLimiteInscription', DateType::class)
            ->add('nbInscriptionMax', IntegerType::class)
            ->add('infosSortie', TextType::class)
            ->add('estOrganisee', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'nom'
            ])
            ->add('site', EntityType::class, [
                'class' => Site::class, 
                'choice_label' => 'nom'
            ])
            ->add('etat', EntityType::class, [
                'class' => Etat::class, 
                'choice_label' => 'libelle'
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
