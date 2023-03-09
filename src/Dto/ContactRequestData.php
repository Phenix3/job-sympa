<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ContactRequestData
{

	#[Assert\NotBlank()]
	#[Assert\Length(min: 3)]
	public ?string $name = '';

	#[Assert\NotBlank()]
	#[Assert\Email()]
	public ?string $email = '';

	#[Assert\NotBlank()]
	#[Assert\Length(min: 5)]
	public ?string $subject = '';

	#[Assert\NotBlank()]
	#[Assert\Length(min: 10)]
	public ?string $content = '';

}