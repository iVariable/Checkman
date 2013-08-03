<?php

namespace Budget\BudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BudgetBundle:Default:index.html.twig', array('name' => $name));
    }
}
