<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ContactController extends AbstractController
{
    #[Route('/', name: 'app_contact_index', methods: ['GET'])]
    public function index(ContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findAll();

        return $this->render('contact/index.html.twig', [
            "contacts" => $contacts
        ]);
    }

    #[Route('/contact/create', name: 'app_contact_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response {

        // 1. Créer un instance du nouveau contact
        $contact = new Contact();

        // 2. Créer le type du formulaire 
        // 3. Créer le formulaire grâce au type du formulaire et de l'instance du nouveau contact
        $form = $this->createForm(ContactFormType::class, $contact);

        // 5. Associer au formulaire, les données de la requête
        $form->handleRequest($request);

        // 6. Si le formulaire est soumis et validate
        if ( $form->isSubmitted() && $form->isValid() ) {

            $contact->setCreatedAt(new DateTimeImmutable());
            $contact->setUpdatedAt(new DateTimeImmutable());

            // 7. Demander au gestionnaire des entités, de préparer et d'exécuter la requête d'insertion du nouveau contact en base de données
            $entityManager->persist($contact);
            $entityManager->flush();

            // 8. Générer le message flash de succès de l'opération
            $this->addFlash('success', "Le contact a été ajouté à la liste.");

            // 9. Effectuer une redirection vers la route menant à la page d'accueil
            return $this->redirectToRoute('app_contact_index');
        }


        // 4. Passer la partie visible du formulaire à la vue, pour affichage.
        return $this->render('contact/create.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
