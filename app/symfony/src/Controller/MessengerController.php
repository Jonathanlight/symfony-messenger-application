<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MessengerController extends AbstractController
{
    /**
     * @Route("/messenger", name="messenger")
     */
    public function index()
    {
        return $this->render('messenger/index.html.twig', [
            'controller_name' => 'MessengerController',
        ]);
    }
}
