<?php

namespace App\Components;

use App\Dto\JobSearchData;
use App\Form\SearchType;
use App\Repository\Job\CategoryRepository;
use App\Repository\Job\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\PreMount;
use function Symfony\Component\Translation\t;

#[AsLiveComponent('home_search')]
class HomeSearchComponent extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    public function __construct(private JobRepository $jobRepository, private CategoryRepository $categoryRepository)
    {
        $this->jobSearchData = new JobSearchData();
    }

    #[LiveProp(writable: true, exposed: ['query', 'categories'])]
    public ?JobSearchData $jobSearchData;

    public function getFilteredJobs()
    {
        return $this->jobRepository->searchJobs($this->jobSearchData)->getResult();
    }

    #[LiveAction]
    public function search(): RedirectResponse
    {
        $this->submitForm();
        return $this->redirectToRoute('app_front_job_search', ['searchData' => $this->jobSearchData]);
    }

    public function getCategories(): array
    {
        return $this->categoryRepository->findAll();
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(SearchType::class, $this->jobSearchData, [
            'method' => 'POST'
        ]);
    }
}