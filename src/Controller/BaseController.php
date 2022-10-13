<?php

namespace App\Controller;

use App\Entity\User\Candidate;
use App\Entity\User\Employer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Candidate|Employer getUser()
 */
class BaseController extends AbstractController
{

}