<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpaController extends AbstractController
{
    #[Route('/spa', name: 'app_spa')]
    public function index(): Response
    {
        return $this->render('spa/index.html.twig', [
            'controller_name' => 'SpaController',
        ]);
    }

    #[Route('/team', name:'app_team')]
    public function team(): Response
    {
        return $this->render('spa/team.html.twig');
    }

    #[Route('/contact', name:'app_contact')]
    public function contact(Request $request, EntityManagerInterface $manager): Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact, [
            'action' => $this->generateUrl('app_contact'),
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($contact);
            $manager->flush();

            return $this->render('spa/contact_success.html.twig');
        }

        return $this->render('spa/contact.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
