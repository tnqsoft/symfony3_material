<?php

namespace Tnqsoft\MaterialBundle\Service;

use \Swift_Mailer as Swift_Mailer;
use \Swift_SmtpTransport as Swift_SmtpTransport;
use \Swift_Message as Swift_Message;
use \Twig_Environment as Environment;

class Email
{
    /**
     * @var string
     */
    private $sender;

    /**
     * @var string
     */
    private $mailerUsername;

    /**
     * @var string
     */
    private $mailerPassword;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * __construct
     *
     * @param string $sender
     * @param string $mailerUsername
     * @param string $mailerPassword
     */
    public function __construct($sender, $mailerUsername, $mailerPassword, Environment $twig)
    {
        $this->sender = $sender;
        $this->mailerUsername = $mailerUsername;
        $this->mailerPassword = $mailerPassword;
        $this->twig = $twig;
    }

    /**
     * Send Email
     *
     * @param  string $to
     * @param  string $template
     * @param  array  $params
     * @return void
     */
    public function send($to, $template, array $params=array())
    {
        $template = $this->twig->loadTemplate($template);
        $subject = $template->renderBlock('subject', $params);
        $body = $template->render($params);

        // Pick random email from list
        $senderKey = array_rand($this->mailerUsername, 1);
        $sender = $this->mailerUsername[$senderKey];
        $transport =  Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
            ->setUsername($sender)
            ->setPassword($this->mailerPassword);
        //http://symfony.com/doc/current/cookbook/email/email.html
        $message = Swift_Message::newInstance()
             ->setSubject($subject)
             ->setFrom($this->sender)
             ->setTo($to)
             ->setBody($body, 'text/html');
             /*
              * If you also want to include a plaintext version of the message
             ->addPart(
                 $this->renderView(
                     'Emails/registration.txt.twig',
                     array('name' => $name)
                 ),
                 'text/plain'
             )
             */
        $mailer = Swift_Mailer::newInstance($transport);
        $mailer->send($message);
        //$this->get('mailer')->send($message);
    }
}
