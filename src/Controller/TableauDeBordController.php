<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Vente;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClientRepository;
use App\Repository\VenteRepository;
use App\Repository\VoitureRepository;

class TableauDeBordController extends AbstractController
{
    #[Route('/', name: 'tableau_de_bord')]
    public function index(Request $request, VoitureRepository $voitureRepository, VenteRepository $venteRepository,ClientRepository $clientRepository): Response
    {
        $voitures = $voitureRepository->findAll();
        $resultatVoiture = count($voitures);
        $ventes = $venteRepository->findAll();
        $resultatVente = count($ventes);
        $clients = $clientRepository ->findAll();
        $resultatClient = count(($clients));
        
        return $this->render('tableau_de_bord/index.html.twig', [
            'controller_name' => 'TableauDeBordController',
            'resultatVoiture' => $resultatVoiture,
            'resultatVente' => $resultatVente,
            'resultatClient'=> $resultatClient,
        ]);
    }

}
