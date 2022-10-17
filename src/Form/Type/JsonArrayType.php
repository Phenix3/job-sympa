<?php

namespace App\Form\Type;

use App\Form\DataTransformer\JsonTransformer;
use Arkounay\Bundle\UxCollectionBundle\Form\UxCollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\ArrayToPartsTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JsonArrayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addModelTransformer(new JsonTransformer());
    }

    public function getParent(): string
    {
        return UxCollectionType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'allow_drag_and_drop' => true,
                'drag_and_drop_filter' => 'input,textarea,a,button,label',
                'display_sort_buttons' => true,
                'add_label' => 'Add an item',
                'min' => 3,
                'max' => 10,
            ]);
    }

}