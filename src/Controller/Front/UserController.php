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
use App\Entity\User\Candidate;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Dto\EmployerSearchData;

#[Route('', name: 'app_front_user_')]
class UserController extends AbstractController
{
	public function __construct(
		private BasicSeoGenerator $seoGenerator,
		private EntityManagerInterface $manager
	) {}

	#[Route('user/{id}', name: 'show')]
	#[Breadcrumb('<i class="fa fa-home"></i>', routeName: 'app_home')]
	#[Breadcrumb('{user.username}')]
	public function show(User $user)
	{
		// $user = $this->manager->getRepository(User::class)->find($id);
		// dump($user);
		return $this->render('front/user/show.html.twig', compact('user'));
	}

    #[Route('/candidate-profile/{id}', name: 'show_candidate')]
    #[Entity('candidate', expr: 'repository.findForShow(id)')]
    public function showCandidate(Candidate $candidate): Response
    {
        return $this->render('front/user/candidate/show.html.twig', compact('candidate'));
    }

    #[Route("companies", name: 'companies')]
    #[Breadcrumb('<i class="fa fa-home"></i>', routeName: 'app_home')]
	#[Breadcrumb('companies')]
    public function indexCompanies(): Response
    {
    	return $this->render('front/user/companies.html.twig', [
    		'employerSearchData' => new EmployerSearchData()
    	]);
    }
}