<?php

namespace App\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use App\Entity\User\User;

class UserSocialType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('socialAccounts', SocialAccountType::class, [
                'help' => 'ui.form.help.email_change'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}