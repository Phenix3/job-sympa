<?php 

namespace App\Dto;

use Symfony\Components\Validator\Constraints as Assert;

class SocialAccountDto
{
	public function __construct(
		#[Assert\NotBlank()]
		#[Assert\Length(min: 10, max: 500)]
		public readonly string $name,

		#[Assert\NotBlank()]
		public readonly string $link
	) {}
}