<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;

class ArticleFormController extends Controller
{
    /**
     * @Route("/article/insert-with-form", name="article_insert_with_form")
     */
    public function insertWithFormAction(Request $request) {
        // 1- créer une instance de Article
        $article = new Article();

        // 2- à partir du service "form.factory", créer un "formBuilder" qui va nous servir à créer
        // un objet formulaire.
        // On appelle la méthode createBuilder du form.factory en lui passant deux paramètres :
        //    1- la classe formulaire créée auparavant : ArticleType::class
        //    2- puis l'objet à lier à ce formulaire : $article
        $formBuilder = $this->get('form.factory')->createBuilder(ArticleType::class, $article);

        // 3- à partir du formBuilder, on génère l'objet formulaire
        $form = $formBuilder->getForm();

        // 4- récupérer les données envoyées pour hydrater l'objet
        $form->handleRequest($request);

        // 5-
        // si le formulaire a été soumis, alors enregistrer l'objet article
        // dont les propriétés ont été automatiquement settées
        // par le composant formulaire lros du "handleRequest"
        if ($form->isSubmitted()) {
            // vérifier si le formulaire est valide
            // isValid() va aller chercher dans la configuration de l'entité les contraintes
            // et automatiquement faire les vérifcations PHP adéquates$

            // toutes les contraintes ici :
            // https://symfony.com/doc/3.4/reference/constraints.html
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();
            }

        }

        // 6- générer le template twig en lui passant la vue de l'objet formulaire
        // dans le template twig "article/insert.html.twig", on aura ainsi accès à la variable formArticle
        return $this->render('article/insert.html.twig', [
            'formArticle' => $form->createView()
        ]);

    }
}