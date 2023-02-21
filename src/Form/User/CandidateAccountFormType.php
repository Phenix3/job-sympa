<?php

namespace App\Form\User;

use App\Entity\Job\Type;
use App\Entity\User\Candidate;
use App\Form\Type\UserAccountType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidateAccountFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('account', UserAccountType::class)
            ->add('jobTitle', TextType::class)
            ->add('jobType', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'name'
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class
        ]);
    }

    public function getParent(): ?string
    {
        return UserAccountType::class;
    }
}