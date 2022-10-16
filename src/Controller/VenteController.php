<?php

namespace App\Controller;

use App\Entity\Vente;
use App\Form\VenteType;
use App\Form\VenteModifierType;
use App\Repository\VenteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VenteController extends AbstractController
{

    #[Route('/rechercheVente', name: 'rechercheVente')]
    public function rechercheVente(Request $request, VenteRepository $venteRepository)
    {
        $dateUne=$request->get(key:'dateUne');
        $dateDeux=$request->get(key:'dateDeux');
        return $this->render('vente/rechercheVente.html.twig',array(
            'ventes'=>$venteRepository->rechercheEntreDeuxDates($dateUne,$dateDeux)
        ));
    }

    #[Route('/readVente/{id<\d+>}', name: 'readVente')]
    public function afficherClient(VenteRepository $venteRepository, Vente $vente){
        $vente=$venteRepository->find($vente);
        return $this->render('vente/afficheVente.html.twig', array(

            'vente'=>$vente,

        ));


    }

    #[Route('/vente', name: 'vente')]
    public function allVente(Request $request, VenteRepository $venteRepository){
        
        $ventes=$venteRepository->findAll();

        return $this->render('vente/listVente.html.twig', array(

            'ventes'=>$ventes

        ));


    }

    #[Route('/ajoutVente', name: 'addVente')]

    public function addVente(Request $request, EntityManagerInterface $em)
    {
        $vente=new Vente();
        $form=$this->createForm(VenteType::class, $vente);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
    
           $em ->persist($vente);
           $vente->getVoiture()->setStatut("Vendu");
           $em ->flush();

           return $this->redirectToRoute('vente');
  
        }
        return $this->render('vente/addVente.html.twig',array(
            'form'=>$form->createView()

        ));
    }

    #[Route("/editVente/{id<\d+>}", name: "updateVente")]

    public function updateVente(Request $request, Vente $vente, EntityManagerInterface $em)
    {
       
        $vente->getVoiture()->getStatut();
        $vente->getVoiture()->setStatut(false);
        $form=$this->createForm(VenteModifierType::class, $vente);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           $vente->getVoiture()->setStatut(true);
           $em->flush();

           return $this->redirectToRoute('vente');
  
        }

        return $this->render('vente/updateVente.html.twig',array(
            'form'=>$form->createView(),
            

        ));
    }

    #[Route("/deleteVente/{id<\d+>}", name : "deleteVente")]

    public function deleteClient(Request $request, Vente $vente, EntityManagerInterface $em)
    {
          $em ->remove($vente);
          $em ->flush();

          return $this->redirectToRoute('vente');

       
    }

}
