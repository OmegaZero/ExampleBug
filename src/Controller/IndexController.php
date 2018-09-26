<?php

namespace App\Controller;

use App\Form\RoleType;
use App\Entity\Employees;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        $Id = $request->query->get('id');

        if (!empty($Id) && $Id != 'add') {
            $search = $this->getDoctrine()
                ->getRepository(Employees::class)
                ->find($Id);

            if (is_null($search))
                $this->addFlash('danger', 'Invalid Client');

            $form = $this->createForm(RoleType::class,$search);
        }
        else {
            $form = $this->createForm(RoleType::class);
        }


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $view = $form->getData();

            dump($view);
        }

        return $this->render('index.html.twig', [
            'controller_name' => 'IndexController',
            'form' => $form->createView()
        ]);
    }
}
