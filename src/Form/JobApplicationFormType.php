<?php

namespace App\Form;

use App\Form\Type\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class JobApplicationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add( 'application', ApplicationType::class)
            ->add('agree', CheckboxType::class)
            ;
    }
}