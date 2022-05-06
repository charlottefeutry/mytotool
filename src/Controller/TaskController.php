<?php

namespace App\Controller;

use App\Entity\ListeTaches;
use App\Entity\Tache;
use App\Repository\ListeTachesRepository;
use App\Repository\TacheRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    //creer taches
    #[Route('/task', name: 'create_task', methods: ['POST'])]
    public function create(Request $request, ManagerRegistry $registry, SessionInterface $session, ListeTachesRepository $listeTachesRepository): JsonResponse
    {
        if(!$request->request->get('nom')) {
            return new JsonResponse(['error' => 'Veuillez renseigner une tâche'], status: Response::HTTP_BAD_REQUEST);
        }
        $task = new Tache();
        $task->setTitre($request->request->get('nom'));
        $task->setListeTache($listeTachesRepository->find($request->request->get('listId')));

        $entityManager = $registry->getManager();
        $entityManager->persist($task);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Task created'], Response::HTTP_CREATED);
    }

    //supprimer tache
    #[Route('/task/{id}', name: 'delete_task', methods: ['DELETE'])]
    public function delete($id, ManagerRegistry $registry, TacheRepository $tacheRepository): JsonResponse
    {
        $tache = $tacheRepository->find($id);

        $entityManager = $registry->getManager();
        $entityManager->remove($tache);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Task deleted'], Response::HTTP_OK);
    }

}
