<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Article;

class ArticleController extends Controller
{
    /**
     * @Route("/article/view", name="article_view")
     */
    public function viewAction() {
        $article = new Article();
        $article->setTitle("Titre de l'article 1");
        $article->setDescription("Ici c'est la description de le produit");

        $response = $this->render('article/view.html.twig', [
            'article' => $article
        ]);
        return $response;
    }

}
