<?php

namespace App\Form;

use App\Entity\Strings;
use App\Entity\SymfonyNodes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SymfonyNodesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $counter=5;
        $builder
            ->add('snid')
            ->add('iid')
            ->add('str',CollectionType::class,[
            'entry_type'=>Strings::class,
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SymfonyNodes::class,
        ]);
    }
}
