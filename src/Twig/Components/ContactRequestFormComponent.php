<?php

namespace App\Twig\Components;

use App\Controller\BaseController;
use App\Dto\ContactRequestData;
use App\Service\ContactService;
use App\Exception\TooManyContactException;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use App\Form\ContactRequestFormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

#[AsLiveComponent('contact_request_form')]
class ContactRequestFormComponent extends BaseController
{
	use DefaultActionTrait;
	use ComponentWithFormTrait;

	#[LiveProp(fieldName: 'data')]
	public ?ContactRequestData $contactRequestData = null;

	protected function instantiateForm(): FormInterface
	{
		return $this->createForm(ContactRequestFormType::class, $this->contactRequestData);
	}

	#[LiveAction()]
	public function send(Request $request, ContactService $contactService)
	{
		$this->submitForm();

		$data = $this->getFormInstance()->getData();
		try {
			$contactService->send($data, $request);
			$this->addFlash('success', 'ui.alerts.contact_request_success');
		} catch (TooManyContactException $e) {
			$this->addFlash('danger', 'ui.alerts.contact_request_error');
		}

		return $this->redirectBack('app_home');
	}
}