<?php

namespace App\Form;

use App\Entity\Job\Category;
use App\Entity\Job\Job;
use App\Entity\Job\Skill;
use App\Entity\Job\Type;
use App\Form\Type\JsonArrayType;
use Arkounay\Bundle\UxCollectionBundle\Form\UxCollectionType;
use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\ArrayFilterType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\ArrayToPartsTransformer;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
            ->add('description', TextareaType::class)
            ->add('responsibilities', JsonArrayType::class, [

            ])
            ->add('education', TextType::class)
            ->add('location', TextType::class)
            ->add('otherBenefits')
            ->add('experience', NumberType::class)
            ->add('salaryMin', NumberType::class)
            ->add('salaryMax', NumberType::class)
            ->add('deadline', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => ['is' => 'date-time-picker'],
            ])
            ->add('requirements')
            ->add('publishedAt', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => ['is' => 'date-time-picker'],
            ])
            ->add('country', CountryType::class)
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
