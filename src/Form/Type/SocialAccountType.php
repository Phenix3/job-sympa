<?php

namespace App\Form\Type;

use App\Entity\User\SocialAccount;
use App\Entity\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocialAccountType extends TextareaType implements DataTransformerInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer($this);
        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver
            ->setDefaults([
                'html5' => false,
                'label' => false,
                'attr' => [
                    'is' => 'social-accounts-editor'
                ],
            ])
            ;
    }

    public function transform(mixed $value)
    {
        // return $value;
        $json = json_encode(collect($value)->map(fn (SocialAccount $socialAccount) => [
            'name' => $socialAccount->getName(),
            'link' => $socialAccount->getLink(),
        ])->toArray(), JSON_THROW_ON_ERROR) ?: '';
        // dd($value, $json);
        return $json;
    }

    public function  reverseTransform(mixed $value)
    {
        dump($value);
        $socialAccounts = \json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        if (null === $socialAccounts) {
            throw new \RuntimeException('Unable to parse the social accounts json: ' . $value);
        }

        return array_map(function($sa) {
            return (new SocialAccount)
                ->setName($sa['name'])
                ->setLink($sa['link']);
        }, $socialAccounts);
    }
}
