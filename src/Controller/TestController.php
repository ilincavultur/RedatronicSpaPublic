<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{


    /**
     * @Route("/test/modal", name="app_test_modal")
     */
    public function testModal()
    {

        return $this->render('Test/test.html.twig');
    }

    /**
     * @Route("/test/modal-to-open", name="app_test_modal_to_open")
     */
    public function testModalToOpen()
    {


        return $this->render('Test/modal-to-open.html.twig');
    }
}