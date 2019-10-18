<?php

namespace App\Controller;

use App\Message\SmsNotification;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MessengerController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(MessageBusInterface $bus)
    {

         // will cause the SmsNotificationHandler to be called
         $bus->dispatch(new SmsNotification('Look! I created a message!'));

         // or use the shortcut
         //$this->dispatchMessage(new SmsNotification('Look! I created a message!'));

        return $this->render('messenger/index.html.twig', [
            'controller_name' => 'Messenger handler',
        ]);
    }
}
