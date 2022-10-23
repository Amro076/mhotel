<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use App\Entity\Chambre;
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\AvisRepository;
use App\Repository\SliderRepository;
use App\Repository\ChambreRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/index', name: 'app_main')]
    public function index(ChambreRepository $repo): Response
    {
        $chambres = $repo->findAll();
        return $this->render('main/index.html.twig', [
            'chambres' => $chambres,
        ]);
    }
    #[Route('/', name: 'home')]
    public function carou( SliderRepository $repo)
    {
        $sliders = $repo->findAll();
        return $this->render('main/home.html.twig', [
            'photos' => $sliders
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
    #[Route('/main/resa/{id}', name: 'app_resa')]
public function resa(Chambre $chambre = null, EntityManagerInterface $manager, Request $rq)
{
    $commande = new Commande;
    $form = $this->createForm(CommandeType::class, $commande);
    $form->handleRequest($rq);

    if ($form->isSubmitted() && $form->isValid()) {
      
        $commande->setCreatedAt(new \DateTime());
        $commande->setChambre($chambre);

        $depart = $commande->getDateArrivee();
        if ($depart->diff($commande->getDateDepart())->invert == 1) {
            // si les dates sont incorrectes, recharge la page et affiche une erreur
            $this->addFlash('danger', 'Une période de temps ne peut pas être négative.');
            return $this->redirectToRoute('app_resa', [
                'id' => $chambre->getId()
            ]);
        }
        $jours = $depart->diff($commande->getDateDepart())->days;
        $prixTotal = ($commande->getChambre()->getPrixJour() * $jours) + $commande->getChambre()->getPrixJour();
        // récupère le prix total (sans la dernière addition, il manque un jour à payer)

        $commande->setPrixTotal($prixTotal);

        $manager->persist($commande);
        $manager->flush();
        
        $this->addFlash('success', 'Votre réservation a bien été enregistrée !');
        return $this->redirectToRoute('app_main');
        
    }

    return $this->renderForm('main/resa.html.twig', [
        'form' => $form,
        'cham' => $chambre
        
    ]);
    }

        #[Route('/main/spa', name: 'spa')]
    public function spa()
    {
        

        return $this->render("main/spa.html.twig", [
            
        ]);
    }
  

    #[Route('/main/contact', name: 'contact')]
    public function contact()
    {
        
        
        return $this->render("main/contact.html.twig", [
            
        ]);
    }

    #[Route('/main/resto', name: 'resto')]
    public function resto()
    {
        

        return $this->render("main/resto.html.twig", [
            
        ]);
    }
    #[Route('/main/lien', name: 'lien')]
    public function lien()
    {
        

        return $this->render("main/lien.html.twig", [
            
        ]);
    }
 


    

    #[Route('/histo', name: 'histo')]
    public function histo()
    {
        
        return $this->render('main/histo.html.twig');
    }
    
    #[Route('/avis', name: 'avis')]
    public function avis(EntityManagerInterface $manager,AvisRepository $repo, Request $request)
    {   
        $avis = new Avis;
        $form = $this->createForm(AvisType::class, $avis);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() )
        {
            
            $manager->persist($avis);
            $manager->flush();

            $this->addFlash('success', 'Merci pour votre avis !');
            return $this->redirectToRoute('avis');
        }
        $avis = $repo->findAll();
        return $this->renderForm('main/avis.html.twig',[
            'form' => $form,
            'avis' => $avis
        ]);
    }
    #[Route('/news', name:'news')]
    public function news()
    {
        $this->addFlash('success', 'Vous étes inscrit! ');
        return $this->redirectToRoute('home');
    }

    


    




   
    


}

