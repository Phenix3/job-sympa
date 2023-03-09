<?php

namespace App\Form;

use App\Dto\ContactRequestData;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;

class ContactRequestFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('name', TextType::class, [
				'label' => 'ui.name'
			])
			->add('email', EmailType::class, [
				'label' => 'ui.email'
			])
			->add('subject', TextType::class, [
				'label' => 'ui.subject'
			])
			->add('content', TextareaType::class, [
				'label' => 'ui.content'
			])
			;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver
			->setDefaults([
				'data_class' => ContactRequestData::class,
			]);
	}
}