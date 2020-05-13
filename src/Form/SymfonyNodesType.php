<?php

namespace App\Form;

use App\Entity\Strings;
use App\Entity\SymfonyNodes;
use App\Entity\Texts;
use App\Entity\Types;
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

        $connections = $options['data']->getConnections();

        $builder->add('text1', TextsType::class,[
            'mapped'=>false
        ]);
        $builder->add('text2', TextsType::class,[
            'mapped'=>false
        ]);


        // foreach ($connections as $connection) {

        //     $motif = substr(get_class($connection), 11);

        //     switch ($motif) {
        //         case 'Texts':
        //             $builder->add('connections', CollectionType::class, [
        //                 'entry_type' => TextsType::class,
        //                 'entry_options' => ['label' => false],
        //                 'allow_add' => true,
        //                 'by_reference'=>false
        //             ]);
        //     dump($connections,$motif);

        //             break;
        //         case 'Types':
        //             $builder->add('connections', CollectionType::class, [
        //                 'entry_type' => TypesType::class,
        //                 'entry_options' => ['label' => false],
        //                 'allow_add' => true,
        //                 'by_reference'=>false
        //             ]);
        //     dump($connection,$motif);

        //             break;

        //         default:
        //             break;
        //     }
        // }

        // $builder->add('connections', CollectionType::class, [
        //         'entry_type' => TypesType::class,
        //         'entry_options' => ['label' => false],
        //         'allow_add' => true,
        //         'by_reference'=>false
        //     ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SymfonyNodes::class,
        ]);
    }
}
