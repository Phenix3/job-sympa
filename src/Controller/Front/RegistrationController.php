<?php

namespace App\Controller\Front;

use App\Entity\User\Employer;
use App\Entity\User\Candidate;
use App\Security\EmailVerifier;
use App\Form\RegistrationFormType;
use Symfony\Component\Mime\Address;
use App\Repository\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Security\AppCandidateAuthenticator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppCandidateAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new Candidate();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            if ($form->get('account_type')->getData() == 'employer') {
                $user = new Employer();
                $user
                    ->setEmail($form->get('email')->getData())
                    ->setUsername($form->get('username')->getData())
                    ;
            }
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

//            dd($user);

            $entityManager->persist($user);
            $entityManager->flush();

            // $verifyEmailRouteName = ($user instanceof Candidate) ? 'app_verify_candidate_email' : 'app_verify_employer_email';

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('no-reply@job-sympa.com', 'Contact'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('front/registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('front/registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyCandidateEmail(Request $request, TranslatorInterface $translator, UserRepository $userRepository): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }
        return $this->verifyUserEmail($user, $request, $translator);
    }

    // #[Route('/verify/employer/email', name: 'app_verify_employer_email')]
    // public function verifyEmployerEmail(Request $request, TranslatorInterface $translator, EmployerRepository $employerRepository): Response
    // {
    //     $id = $request->get('id');

    //     if (null === $id) {
    //         return $this->redirectToRoute('app_register');
    //     }

    //     $user = $employerRepository->find($id);

    //     if (null === $user) {
    //         return $this->redirectToRoute('app_register');
    //     }

    //     return $this->verifyUserEmail($user, $request, $translator);
    // }

    private function verifyUserEmail(UserInterface $user, Request $request, TranslatorInterface $translator)
    {
        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
}
