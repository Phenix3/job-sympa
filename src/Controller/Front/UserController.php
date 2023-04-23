<?php

namespace App\Controller\Front;

use App\Controller\BaseController;
use App\Dto\EmployerSearchData;
use App\Entity\User\Candidate;
use App\Entity\User\User;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Doctrine\ORM\EntityManagerInterface;
use Leogout\Bundle\SeoBundle\Seo\Basic\BasicSeoGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('', name: 'app_front_user_')]
class UserController extends BaseController
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
		$user->setViewCount((int) $user->getViewCount() + 1);
		$this->manager->flush();
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
    public function companies(): Response
    {
    	return $this->render('front/user/companies.html.twig', [
    		'employerSearchData' => new EmployerSearchData()
    	]);
    }
}
