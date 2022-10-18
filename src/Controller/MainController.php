<?php

namespace App\Controller;

use App\Repository\ChambreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ChambreRepository $repo): Response
    {
        $chambres = $repo->findAll();
        return $this->render('main/index.html.twig', [
            'chambres' => $chambres,
        ]);
    }

    #[Route('/main/show/{id}', name: 'app_show')]
    public function show($id, ChambreRepository $repo)
    {
        $chambre = $repo->find($id);
        return $this->render('main/show.html.twig', [
            'item' => $chambre,
        ]);
    }
}
