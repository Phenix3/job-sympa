<?php

namespace App\Controller\Front;

use App\Controller\BaseController;
use Symfony\Component\Routing\Annotation\Route;
use App\Dto\ContactRequestData;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;


#[Route('/', name: 'app_front_contact_')]
class ContactController extends BaseController
{

	#[Route('/contact', name: 'request', methods: ['GET', 'POST'])]
	#[Breadcrumb('<i class="lni lni-home"></i>', routeName: 'app_home')]
	#[Breadcrumb('<i class="lni lni-phone"></i> Contact', routeName: 'app_front_contact_request')]
	public function request()
	{
		$contactRequestData = new ContactRequestData();
		return $this->render('front/contact/request.html.twig', compact('contactRequestData'));
	}
}