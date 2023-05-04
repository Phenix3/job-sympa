<?php

namespace App\Controller\Admin;

use App\Entity as Entity;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
//        return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
         return $this->render('admin/dashboard/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Job Sympa');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Job', 'fa fa-dashboard');
        yield MenuItem::linkToCrud('Categories', 'fa fa-box', Entity\Job\Category::class);
        yield MenuItem::linkToCrud('Types', 'fa fa-list', Entity\Job\Type::class);
        yield MenuItem::linkToCrud('Jobs', 'fa fa-list', Entity\Job\Job::class);
        yield MenuItem::section('Users', 'fa fa-users');
        yield MenuItem::linkToCrud('Candidates', 'fa fa-users', Entity\User\Candidate::class);
        yield MenuItem::linkToCrud('Employers', 'fa fa-companies', Entity\User\Employer::class);
        yield MenuItem::linkToCrud('Countries', 'fa fa-flag', Entity\Country::class);
        yield MenuItem::linkToCrud('Settings', 'fa fa-cogs', Entity\Setting::class);
        yield MenuItem::linkToCrud('Notifications', 'fa fa-bell', Entity\Notification::class);

    }
}
