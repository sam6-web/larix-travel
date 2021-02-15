<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AppController extends Controller
{
    /**
     * @Route("/", name="app")
     */
    public function index()
    {
        return $this->render('index.html.twig', [

        ]);
    }

    /**
     * @Route("/admin")
     */
    public function admin()
    {
        return $this->render('admin.html.twig', [

        ]);
    }

}
