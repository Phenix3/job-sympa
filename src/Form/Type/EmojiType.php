<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;

use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Intl\Countries;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmojiType extends AbstractType
{
	public function getParent(): string
	{
		return CountryType::class;
	}

	public static function getEmojiFlag(string $code): string
	{
		$regionalOffset = 0x1F1A5;
		return mb_chr($regionalOffset + mb_ord($code[0], 'UTF-8'), 'UTF-8')
			. mb_chr($regionalOffset + mb_ord($code[1], 'UTF-8'), 'UTF-8');
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'choice_loader' => function(Options $options) {
				return ChoiceList::lazy($this, function() use($options) {
					$choices = [];
					$countriesCode = Countries::getNames($options['choice_translation_locale']);

					foreach($countriesCode as $cc => $displayed){
						$choices[$cc] = self::getEmojiFlag($cc) . ' ' . $displayed;
					}
					return array_flip($choices);
				});
			},
			'choice_translation_locale' => null
		]);

		$resolver->setAllowedTypes('choice_translation_locale', ['null', 'string']);
	}
}
