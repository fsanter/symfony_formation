<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/test", name="test_page")
     */
    public function testAction(Request $request)
    {
        $response = $this->render('default/test.html.twig');
        return  $response;
        /*
        return new Response("
            <!DOCTYPE html>
            <html>
                <head></head>
                <body>Coucou</body>
            </html>
        ");
        */
    }

    /**
     * @Route("/page-de-test", name="toto")
     */
    public function totoAction(Request $request)
    {
        return new Response("0");
    }

    /**
     * @Route("/page-de-test-avec-template", name="toto2")
     */
    public function toto2Action(Request $request)
    {
        $templateHtml = $this->renderView('default/page_test_template.html.twig');
        return new Response($templateHtml);
    }
}
