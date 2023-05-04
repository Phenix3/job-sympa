<?php

namespace App\Service;

use App\Messenger\EnqueueMethod;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MailerService
{
    public function __construct(private Environment $twig, private MailerInterface $mailer, private EnqueueMethod $enqueueMethod)
    {}

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function createEmail(string $template, array $data = []): Email
    {
        $this->twig->addGlobal('format', 'html');
        $html = $this->twig->render($template, array_merge($data, ['layout' => 'mails/base.html.twig']));

        $this->twig->addGlobal('format', 'txt');
        $text = $this->twig->render($template, array_merge($data, ['layout' => 'mails/base.txt.twig']));

        return (new Email())
            ->from('noreply@sahelsystem.com')
            ->html($html)
            ->text($text)
            ;
    }

    public function send(Email $email): void
    {
        $this->mailer->send($email);
    }
}