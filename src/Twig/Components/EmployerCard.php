<?php
namespace App\Twig\Components;

use App\Entity\User\Employer;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('employer_card')]
class EmployerCard
{
	public Employer $employer;
}