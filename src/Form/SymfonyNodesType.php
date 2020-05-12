<?php

namespace App\Form;

use App\Entity\Strings;
use App\Entity\SymfonyNodes;
use App\Entity\Texts;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SymfonyNodesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $counter = 5;
        $builder
            ->add('connections', CollectionType::class, [
                'entry_type' => TextsType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference'=>false
            ])
            ->add('connections', CollectionType::class, [
                'entry_type' => TypesType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference'=>false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SymfonyNodes::class,
        ]);
    }
}
