<?php

namespace App\Controller\Front;

use Leogout\Bundle\SeoBundle\Seo\Basic\BasicSeoGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(BasicSeoGenerator $seoGenerator): Response
    {
        dump($this->getUser());
        $seoGenerator
            ->setTitle("Job Sympa")
            ->setDescription("Trouver le job de vos reves")
            ->setKeywords("job, work, job board")
            ;
        return $this->render('front/home/index.html.twig');
    }
}
