<?php

namespace App\Controller;

use App\Repository\ListeTachesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ListeTachesRepository $listeTachesRepository, SessionInterface $session): Response
    {
       if(!$session->get('utilisateur')) {
           return $this->redirectToRoute('login');
       }

       $userList = $listeTachesRepository->findBy(['utilisateur' => $session->get('utilisateur')]);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'listes' => $userList,
        ]);
    }


}
