<?php

namespace App\Asset;

use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\Asset\PackageInterface;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\HttpFoundation\RequestStack;



final class AssetPackage implements PackageInterface
{
    public const PACKAGE_NAME = 'easyadmin.assets.package';

    private PackageInterface $package;

    public function __construct(RequestStack $requestStack)
    {
        $this->package = new PathPackage(
            '/',
            new EmptyVersionStrategy(),
            new RequestStackContext($requestStack)
        );
    }

    public function getUrl(string $assetPath): string
    {
        return $this->package->getUrl($assetPath);
    }

    public function getVersion(string $assetPath): string
    {
        return $this->package->getVersion($assetPath);
    }
}
