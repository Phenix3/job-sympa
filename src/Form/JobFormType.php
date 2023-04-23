<?php

namespace App\Form;

use App\Entity\Job\Category;
use App\Entity\Job\Job;
use App\Entity\Job\Skill;
use App\Entity\Job\Type;
use App\Form\Type\CountryType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class, [
                'attr' => ['is' => 'wysiwyg-editor']
            ])
            ->add('responsibilities', TextareaType::class, [
                'attr' => ['is' => 'wysiwyg-editor']
            ])
            ->add('education', TextType::class)
            ->add('location', TextType::class)
            ->add('otherBenefits', TextareaType::class, [
                'attr' => ['is' => 'wysiwyg-editor']
            ])
            ->add('experience', IntegerType::class)
            ->add('salaryMin', IntegerType::class)
            ->add('salaryMax', IntegerType::class)
            ->add('deadline', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => ['is' => 'date-time-picker'],
            ])
            ->add('requirements', TextareaType::class, [
                'attr' => ['is' => 'wysiwyg-editor']
            ])
            ->add('publishedAt', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => ['is' => 'date-time-picker'],
            ])
            ->add('country', CountryType::class, [
                'attr' => [
                    'is' => 'select-selectize'
                ]
            ])
            ->add('city')
            ->add('fullAddress')
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'multiple' => true,
                'attr' => ['is' => 'select-selectize'],
            ])
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'attr' => ['is' => 'select-selectize'],
            ])
            ->add('requiredSkills', EntityType::class, [
                'class' => Skill::class,
                'multiple' => true,
                'attr' => ['is' => 'select-selectize'],
            ])
            ->add('isFreelance', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'checkbox-custom'
                ],
                'label_attr' => [
                    'class' => 'checkbox-custom-label'
                ]
            ])
            ->add('isSuspended', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'checkbox-custom'
                ],
                'label_attr' => [
                    'class' => 'checkbox-custom-label'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
