<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Form\Model\ContactFormModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact.index")
     */
    public function index(Request $request):Response
    {
//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /*
         * affichage d'un formulaire
         *   se base
         *      - sur l'espace de noms de la classe de formulaire
         *      - sur une instance du modèle relié à la classe de formulaire
         *  handleRequest permet de récupérer la saisie dans la requête HTTP
         *  createView permet d'envoyer le formulaire sous forme de vue
         */
        $type = ContactType::class;
        $model = new ContactFormModel();
        $form = $this->createForm($type, $model);
        $form->handleRequest($request);

        // si le formulaire est valide
        if($form->isSubmitted() && $form->isValid()){

            // message flash : message stocké en session et affiché une seule fois
            $this->addFlash('notice', "Votre message a été envoyé");

            // redirection vers une route par son nom
            return $this->redirectToRoute('homepage.index');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}







