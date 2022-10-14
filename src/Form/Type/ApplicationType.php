<?php

namespace App\Form\Type;

use App\Entity\Job\Application;
use App\Entity\User\CandidateCvs;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ApplicationType extends AbstractType
{
    public function __construct(private TokenStorageInterface $tokenStorage, private EntityManagerInterface $manager)
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message', TextareaType::class);
//            ->add('job')
//            ->add('candidate')
        if ($this->tokenStorage->getToken() && $this->tokenStorage->getToken()->getUser()) {

        $builder
            ->add('cv', EntityType::class, [
                'class' => CandidateCvs::class,
                'query_builder' => $this->manager->getRepository(CandidateCvs::class)->findForCandidateBuilder($this->tokenStorage->getToken()->getUser()),
                'placeholder' => 'ui.form.select_resume'
            ])
        ;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
