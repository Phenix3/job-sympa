<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;

use Symfony\Component\Form\Extension\Core\Type\CountryType as BaseCountryType;
use Symfony\Component\Intl\Countries;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Asset\PackageInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

use App\Entity\Country;

class CountryType extends AbstractType
{
	public function __construct(private PackageInterface $assetPackage, private EntityManagerInterface $em)
	{}

	public function getCountryFlag(string $code): string
	{
		return $this->assetPackage->getUrl(sprintf('images/flags/%s.svg', $code));
	}

	public function getParent(): string
	{
		return EntityType::class;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'class' => Country::class,
			'choices' => $this->getChoices(),
			'choice_label' => 'name',
			'choice_value' => 'id',
			'show_flag' => true,
		]);

		$resolver->setAllowedTypes('show_flag', ['null', 'boolean']);
	}

	public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        if ($options['show_flag']) {
            foreach ($view as $childView) {
    			dump($childView);
                $childView->vars['flag'] = 'country-flag';
            }
        }
    }

	private function getChoices()
	{
		$countries = $this->em->getRepository(Country::class)->findAll();
		return ChoiceList::lazy($this, function() use($countries) {
			$choices = [];
			foreach ($countries as $country) {
				$choices[$country->getName()] = $contry->getId();
			}
			return $choices;
		});
	}

	public function getBlockPrefix(): string
	{
		return 'country_flagged';
	}
}
