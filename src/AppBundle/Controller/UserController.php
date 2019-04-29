<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @Route("/user/insert", name="user_insert")
     */
    public function insertAction() {
        $email = "fab3@mail.fr";

        // 1- créer une instance de User
        $user = new User();
        $user->setEmail($email);
        $user->setDateNaissance(new \DateTime("1995-12-31"));
        $user->setPassword("pass123");

        // 2- récupérer le manager d'entité de doctrine
        $em = $this->getDoctrine()->getManager();

        // 3- vérifiez que l'email n'existe pas déjà en base
        $userExist = $em->getRepository('AppBundle:User')
                        ->findOneBy(['email' => $email]);

        if ($userExist == null) {
            // 4- enregistrer en base
            $em->persist($user);
            $em->flush();
            return new Response("User bien enregistré ".$user->getId());
        }
        else {
            return new Response($email. " est déjà existant");
        }
    }

    /**
     * @Route("/user/view/{id}", name="user_view")
     */
    public function viewAction($id) {
        // 1- récupérer le manager
        $em = $this->getDoctrine()->getManager();

        // 2- récupérer un entristrement en base pour l'utiliser en objet
        $user = $em->getRepository('AppBundle:User')->find($id);

        // 3- passer cette entité à un template pour l'afficher
        $response = $this->render('user/view.html.twig', [
            'user' => $user
        ]);

        return $response;
    }

    /**
     * @Route("/user/remove/{id}", name="user_remove")
     */
    public function removeAction($id) {
        // 1- récupérer le manager
        $em = $this->getDoctrine()->getManager();

        // 2- récupérer un entristrement en base pour l'utiliser en objet
        $user = $em->getRepository('AppBundle:User')->find($id);

        // 3- dire à doctrine de supprimer cette entité
        $em->remove($user);
        $em->flush();

        return new Response("User bien supprimé");
    }

}
