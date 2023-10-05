<?php

namespace App\Service;

use App\Repository\User\UserRepository;

class UserService
{
	public function __construct(private UserRepository $userRepository){}
}
