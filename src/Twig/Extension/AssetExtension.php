<?php
namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
// use Symfony\Component\Asset\PackageInterface;
use App\SettingManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\Asset\Packages;

class AssetExtension extends AbstractExtension
{
	public function __construct(
		private Packages $assetPackage, 
		private SettingManager $settingManager,
		private UploaderHelper $uploaderHelper,
		private CacheManager $imagineCache
	) {}

	public function getFunctions(): array
	{
		return [
			new TwigFunction('avatar', [$this, 'getAvatar'])
		];
	}

	public function getAvatar(object $entity, ?string $field = null, ?string $filter = null)
	{
		$avatarName = $entity->{"get".\ucfirst($field)}();
		if(null === $field || null == $avatarName) {
			return $this->assetPackage->getUrl($this->settingManager->get('default_employer_avatar'));
		} else {
			$source = $this->uploaderHelper->asset($entity, $field);
			if (null === $filter) {
				return $source;
			} else {
				return $this->imagineCache->getBrowserPath(parse_url($source, PHP_URL_PATH), $filter);
			}
		}
	}
}