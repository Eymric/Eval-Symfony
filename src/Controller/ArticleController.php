<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\ContinentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="article.index")
     */
    public function index(ContinentRepository $continentRepository):Response
    {
        for($i=38;$i < 44; $i++)
        {
            $continents[] = $continentRepository->find($i)->getArticles();
        }

        return $this->render('article/index.html.twig', [
            'continents' => $continents
        ]);
    }


    /**
     * @Route("/article/{slug}", name="article.details")
     */

    public function details(string $slug, ArticleRepository $articleRepository):Response
    {
       $article = $articleRepository->findOneBy([
            'slug' => $slug
        ]);

       $continent = $article->getContinent()->getName();

        return $this->render('article/details.html.twig', [
            'article' => $article,
            'continent' => $continent
        ]);
    }

}
