<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /*
         *  annotation Route permet de définir une route (URL)
         *     - schéma de la route : URL
         *     - nom unique de la route
         *          nomenclature recommandée : <nom du contrôleur>.<nom de la méthode>
         *  dans les annotations, utiliser uniquement des doubles guillemets
         */

    /**
     * @Route("/", name="homepage.index")
     */
    public function index(Request $request, ArticleRepository $articleRepository):Response
    {
        $userAgent = $request->server->get('HTTP_USER_AGENT');
        $articles = $articleRepository->findBy( [], null, 3);
        return $this->render('homepage/index.html.twig', [
            'param' => $userAgent,
            'articles' => $articles
        ]);
    }

}
