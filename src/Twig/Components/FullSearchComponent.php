<?php

namespace App\Components;

use App\Dto\JobSearchData;
use App\Repository\Job\JobRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('full_search')]
class FullSearchComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true, exposed: ['page', 'query', 'categories', 'type', 'location'])]
    public JobSearchData $jobSearchData;

    /**
     * @param PaginatorInterface $paginator
     * @param JobRepository $jobRepository
     */
    public function __construct(private PaginatorInterface $paginator, private JobRepository $jobRepository)
    {
    }


    /**
     * @return PaginationInterface
     */
    public function getJobs(): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->jobRepository->searchJobs($this->jobSearchData),
            $this->jobSearchData->page ?: 1
        );
    }

    public function resetPage()
    {
        $this->jobSearchData->page = 1;
    }

    #[LiveAction()]
    public function prev()
    {
        $this->jobSearchData->page -= 1;
    }


    #[LiveAction()]
    public function next()
    {
        $this->jobSearchData->page += 1;
    }

}