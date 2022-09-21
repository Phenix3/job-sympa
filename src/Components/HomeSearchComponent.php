<?php

namespace App\Components;

use App\Dto\JobSearchData;
use App\Form\SearchType;
use App\Repository\Job\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
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

    public ?JobSearchData $jobSearchData = null;

    #[LiveProp(writable: true)]
    public ?array $jobs = [];

    public function __construct(private JobRepository $jobRepository)
    {
        $this->jobSearchData = new JobSearchData();
    }


    #[LiveAction()]
    public function search()
    {
        $this->submitForm();
        $this->jobSearchData = $this->getFormInstance()->getData();
//        $this->jobs = $this->jobRepository->searchJobs($this->jobSearchData)->getResult();
    }

    public function getFilteredJobs()
    {
        return $this->jobRepository->searchJobs($this->jobSearchData)->getResult();
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(SearchType::class, $this->jobSearchData);
    }
}