<?php
namespace App\Twig\Components;

use App\Controller\BaseController;
use App\Dto\EmployerSearchData;
use App\Repository\User\EmployerRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('employers_search')]
class EmployersSearchComponent extends BaseController
{
	use DefaultActionTrait;

	#[LiveProp(writable: true, exposed: ['name', 'page', 'categories', 'country'])]
	public EmployerSearchData $employerSearchData;

	public function __construct(private EmployerRepository $repository, private PaginatorInterface $paginator)
	{}

	public function getEmployers(): ?PaginationInterface
	{
		$employers = $this->paginator->paginate(
			$this->repository->searchEmployersQuery($this->employerSearchData),
			$this->employerSearchData->page ?: 1,
			$this->employerSearchData->perPage
		);
        dump($employers);
        return $employers;
	}

	public function resetPage()
    {
        $this->employerSearchData->page = 1;
    }

    #[LiveAction()]
    public function prev()
    {
        $this->employerSearchData->page -= 1;
    }


    #[LiveAction()]
    public function next()
    {
        $this->employerSearchData->page += 1;
    }
}
