<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class ArticleController extends AbstractController
{
	/**
	 * @Route("/articles", name="admin.article.index")
	 */
	public function index(ArticleRepository $articleRepository):Response
	{
		$results = $articleRepository->findAll();

		return $this->render('admin/article/index.html.twig', [
			'results' => $results
		]);
	}

    /**
     * @Route("/articles/delete/{id}", name="admin.article.delete")
     */
	public function delete(EntityManagerInterface $entityManager, ArticleRepository $articleRepository, int $id):Response
    {
        $entity = $articleRepository->find($id);
        $entityManager->remove($entity);
        $entityManager->flush();

        $this->addFlash('notice', 'L\'article a été supprimé');
        return $this->redirectToRoute('admin.article.index');
    }


	/**
     * @Route("/articles/form", name="admin.article.form")
     * @Route("/articles/form/update/{id}", name="admin.article.form.update")
     */
	public function form(Request $request, EntityManagerInterface $entityManager, int $id = null, ArticleRepository $articleRepository):Response
    {
        // Affichage d'un formulaire
        $type = ArticleType::class;
        $model = $id ? $articleRepository->find($id) : new Article();
        $form = $this->createForm($type, $model);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
//dd($model);
            $id ? null : $entityManager->persist($model);
            $entityManager->flush();

            $message = "L'article a été ajouté";
            $this->addFlash('notice', $message);

            return $this->redirectToRoute('admin.article.index');
        }


        return $this->render('admin/article/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

}










