<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/readClient/{id<\d+>}', name: 'ReadClient')]
    public function afficherClient(ClientRepository $clientRepository, Client $client){
        $client=$clientRepository->find($client);
        return $this->render('client/afficheClient.html.twig', array(

            'client'=>$client,

        ));


    }

    #[Route('/client', name: 'client')]
    public function allClient(Request $request, ClientRepository $clientRepository){
        if ($request->isMethod(method:"POST"))
        {
            $selectrecherche = $request->get(key:'selectrecherche');
            $searchclient = $request->get(key:'searchclient');
            $clients=$clientRepository->findBy(array($selectrecherche=>$searchclient));

            return $this->render('client/rechercheClient.html.twig',array(

                'clients'=>$clients
      
              )); 
        }
        else{
            $clients=$clientRepository->findAll();

            return $this->render('client/listClient.html.twig', array(

          'clients'=>$clients

        ));
        }

    }

    #[Route('/ajoutClient', name: 'addClient')]

    public function addClient(Request $request, EntityManagerInterface $em)
    {
        $client=new Client();
        $form=$this->createForm(ClientType::class, $client);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
    
           $em ->persist($client);
           $em ->flush();

           return $this->redirectToRoute('client');
  
        }
        return $this->render('client/addClient.html.twig',array(
            'form'=>$form->createView(), 

        ));
    }

    #[Route("/editClient/{id<\d+>}", name: "updateClient")]

    public function updateClient(Request $request, Client $client, EntityManagerInterface $em)
    {
       
        
        $form=$this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           $em->flush();

           return $this->redirectToRoute('client');
  
        }

        return $this->render('client/updateClient.html.twig',array(
            'form'=>$form->createView(),
            

        ));
    }

    #[Route("/deleteClient/{id<\d+>}", name : "deleteClient")]

    public function deleteClient(Request $request, Client $client, EntityManagerInterface $em)
    {
          $em ->remove($client);
          $em ->flush();

          return $this->redirectToRoute('client');

       
    }
    
}

