<?php

namespace App\Form\User;

use App\Entity\User\CandidateCvs;
use App\Form\Type\AttachmentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidateResumeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isDefault', CheckboxType::class, [
                'required' => false
            ])
            ->add('title', TextType::class)
            ->add('jobTitle', TextType::class)
            ->add('file', AttachmentType::class, [
                'label' => 'ui.form.resume_file'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CandidateCvs::class,
        ]);
    }
}
