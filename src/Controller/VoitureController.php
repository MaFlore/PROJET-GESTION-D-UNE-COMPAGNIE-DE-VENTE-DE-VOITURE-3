<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController
{
    #[Route("/voiture",name: "allVoiture")]

    public function allVoiture(Request $request, VoitureRepository $voitureRepository){
        if ($request->isMethod(method:"POST"))
        {
            $selectrecherche = $request->get(key:'selectrecherche');
            $searchvoiture = $request->get(key:'searchvoiture');
            $voitures=$voitureRepository->findBy(
                array($selectrecherche=>$searchvoiture)
            );
            return $this->render('voiture/rechercheVoiture.html.twig',array(

                'voitures'=>$voitures
      
              )); 
        }
        else{
            $voitures=$voitureRepository->findAll();

            return $this->render('voiture/listVoiture.html.twig', array(

          'voitures'=>$voitures

        ));
        }

    }

    #[Route('/ajoutVoiture', name: 'addVoiture')]

    public function addVoiture(Request $request, EntityManagerInterface $em)
    {
        $voiture=new Voiture();
        $form=$this->createForm(VoitureType::class, $voiture);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
    
           $em ->persist($voiture);
           $em ->flush();

           return $this->redirectToRoute('allVoiture');
  
        }
        return $this->render('voiture/addVoiture.html.twig',array(
            'form'=>$form->createView()

        ));
    }

    #[Route("/editVoiture/{id<\d+>}", name: "updateVoiture")]

    public function updateVoiture(Request $request, Voiture $voiture, EntityManagerInterface $em)
    {
       
        
        $form=$this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           $em->flush();

           return $this->redirectToRoute('allVoiture');
  
        }

        return $this->render('voiture/updateVoiture.html.twig',array(
            'form'=>$form->createView()

        ));
    }

    #[Route("/deleteVoiture/{id<\d+>}", name : "deleteOneVoiture")]

    public function deleteVoiture(Request $request, Voiture $voiture, EntityManagerInterface $em)
    {
          $em ->remove($voiture);
          $em ->flush();

          return $this->redirectToRoute('allVoiture');

       
    }

    #[Route("/refuserSupprimer")]

    public function refuserSupprimer()
    {
          return $this->redirectToRoute('allVoiture');

    }

    #[Route("/deletePage/{id<\d+>}")]

    public function deletePage(Voiture $voitures)
    {
        return $this->render('voiture/deleteVoiture.html.twig',array(

            'voitures'=>$voitures));

    }
}
