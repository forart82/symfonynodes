<?php

namespace App\Form;

use App\Entity\Texts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

class TextsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Texts::class,
        ]);
    }

    // /**
    //  * @param Texts|null $viewData
    //  */
    // public function mapDataToForms($viewData, $forms)
    // {
    //     // there is no data yet, so nothing to prepopulate
    //     if (null === $viewData) {
    //         return;
    //     }

    //     // invalid data type
    //     if (!$viewData instanceof Texts) {
    //         throw new UnexpectedTypeException($viewData, Texts::class);
    //     }
    //     /** @var FormInterface[] $forms */
    //     $forms = iterator_to_array($forms);

    //     // initialize form field values
    //     $forms['content']->setData($viewData->getContent());
    // }

    // public function mapFormsToData($forms, &$viewData)
    // {
    //     /** @var FormInterface[] $forms */
    //     $forms = iterator_to_array($forms);

    //     // as data is passed by reference, overriding it will change it in
    //     // the form object as well
    //     // beware of type inconsistency, see caution below
    //     $viewData = new Texts(
    //         $forms['content']->getData()
    //     );
    // }
}
