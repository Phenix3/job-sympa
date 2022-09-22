<?php

namespace App\Components;

use App\Dto\JobSearchData;
use App\Repository\Job\JobRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
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
        dump($this->jobSearchData);
        return $this->paginator->paginate(
            $this->jobRepository->searchJobs($this->jobSearchData),
            $this->searchData->page ?? 1
        );
    }

}