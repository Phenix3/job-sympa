<?php
namespace App\Form\Type;

use App\Entity\Country;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\FormView;
use Symfony\Component\Asset\Packages;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CountryType extends AbstractType
{
	public function __construct(private Packages $assetPackage, private EntityManagerInterface $em)
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
			// 'choice_loader' => $this->getChoices(),
			// 'choice_label' => 'name',
			// 'choice_value' => 'id',
            'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('c'),
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
            dump($countries);
			$choices = [];
			foreach ($countries as $country) {
				$choices[$country->getName()] = $country->getId();
			}
			return $choices;
		});
	}

	public function getBlockPrefix(): string
	{
		return 'country_flagged';
	}
}
