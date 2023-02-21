<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Leogout\Bundle\SeoBundle\Seo\Basic\BasicSeoGenerator;
use Doctrine\ORM\EntityManagerInterface;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use App\Entity\User\User;

#[Route('', name: 'app_front_user_')]
class UserController extends AbstractController
{
	public function __construct(private EntityManagerInterface $manager){}

	#[Route('user/{id}', name: 'show')]
	#[Breadcrumb('<i class="fa fa-home"></i>', routeName: 'app_home')]
	#[Breadcrumb('')]
	public function show(int $id)
	{
		$user = $this->manager->getRepository(User::class)->find($id);
		dump($user);
		return $this->render('front/user/show.html.twig', compact('user'));
	}
}