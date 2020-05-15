<?php

namespace App\Form;

use App\Entity\Motifs;
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
        $values = [
            'getTexts',
            'getMotifs',
            'getStrings',
            'getTypes',
            'getImages',
        ];

        foreach ($values as $value) {
            $connections = $options['data']->$value();
            foreach ($connections as $connection) {
                $class = substr(get_class($connection), 11);
                $type = 'App\\Form\\' . $class . 'Type';
                $builder->add(strtolower($class), CollectionType::class, [
                    'entry_type' => $type,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'by_reference' => false,
                ]);
            }
        }



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
            'allow_extra_fields' => true,
        ]);
    }
}
