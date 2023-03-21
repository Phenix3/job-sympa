<?php

namespace App\Twig\Components;

use App\Dto\JobSearchData;
use App\Repository\Job\CategoryRepository;
use App\Repository\Job\JobRepository;
use App\Repository\Job\TypeRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('full_search')]
class FullSearchComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true, exposed: ['page', 'query', 'categories', 'types', 'location', 'country', 'sort', 'direction'])]
    public JobSearchData $jobSearchData;

    /**
     * @param PaginatorInterface $paginator
     * @param JobRepository $jobRepository
     */
    public function __construct(private PaginatorInterface $paginator, private JobRepository $jobRepository, private CategoryRepository $categoryRepository, private TypeRepository $typeRepository)
    {
    }


    /**
     * @return PaginationInterface
     */
    public function getJobs(): PaginationInterface
    {
        $jobs = $this->paginator->paginate(
            $this->jobRepository->searchJobs($this->jobSearchData),
            $this->jobSearchData->page ?: 1
        );
        return $jobs;
    }

    public function getCategories()
    {
        return $this->categoryRepository->findLatest();
    }

    public function getTypes()
    {
        return $this->typeRepository->findAll();
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

    #[LiveAction()]
    public function sort()
    {
        dump($this->jobSearchData->sort);
    }

}
