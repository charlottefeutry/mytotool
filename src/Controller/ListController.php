<?php

namespace App\Controller;

use App\Entity\ListeTaches;
use App\Repository\ListeTachesRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    //creer liste
    #[Route('/list', name: 'create_list', methods: ['POST'])]
    public function create(Request $request, ManagerRegistry $registry, SessionInterface $session, UtilisateurRepository $utilisateurRepository): JsonResponse
    {
        if(!$request->request->get('nom')) {
            return new JsonResponse(['error' => 'Veuillez renseigner un nom'], status: Response::HTTP_BAD_REQUEST);
        }
        $list = new ListeTaches();
        $list->setNom ($request->request->get('nom'));
        $list->setUtilisateur($utilisateurRepository->find($session->get('utilisateur')->getId()));

        $entityManager = $registry->getManager();
        $entityManager->persist($list);
        $entityManager->flush();

        return new JsonResponse(['message' => 'List created'], Response::HTTP_CREATED);
    }

    //ajouter liste
    #[Route('/list/{listId}', name: 'app_liste_list')]
    public function listDetail(?string $listId, Session $session, ListeTachesRepository $listeTachesRepository): Response
    {

        $userList = $listeTachesRepository->findBy(['utilisateur' => $session->get('utilisateur')]);

        $list = $listeTachesRepository->find($listId);

        return $this->render('list/index.html.twig', [
            'controller_name' => 'ListController',
            'utilisateur' => $session->get('utilisateur'),
            'listes' => $userList,
            'listeDetails' => $list,
        ]);
    }



    //supprimer liste
     #[Route('/list', name: 'supprimer_liste', methods: ['DELETE'])]

     public function delete(Request $request, ManagerRegistry $registry, SessionInterface $session, ListeTachesRepository $listeTachesRepository): JsonResponse
     {
         if(!$request->request->get('listId')) {
             return new JsonResponse(['error' => 'Veuillez renseigner une liste'], Response::HTTP_BAD_REQUEST);
         }

         $list = $listeTachesRepository->find($request->request->get('listId'));

         $entityManager = $registry->getManager();
         $entityManager->remove($list);
         $entityManager->flush();

         return new JsonResponse(['message' => 'Liste supprimée'], Response::HTTP_CREATED);

     }
}

