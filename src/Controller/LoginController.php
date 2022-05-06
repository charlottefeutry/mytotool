<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function index(Request $request, UtilisateurRepository $utilisateurRepository, SessionInterface $session): Response
    {
        if($session ->get('utilisateur')) {
            return $this->redirectToRoute( route:'home');
        }

        if($request->isMethod( method:'post')) {
            $identifiant = $request->request->get( key: 'identifiant');
            $user = $utilisateurRepository->findOneBy(['identifiant' => $identifiant]);

            if($user != null) {
                $session->set('utilisateur', $user);
            return $this->redirectToRoute( route: 'home');
            }

            $this->addFlash( 'error', 'Identifiant incorrect');
        }

        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(SessionInterface $session): Response
    {
        $session->clear();

        return $this->redirectToRoute('login');
    }

}
