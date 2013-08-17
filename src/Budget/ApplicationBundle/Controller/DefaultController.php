<?php

namespace Budget\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class DefaultController extends Controller
{

    /**
     *
     * @Route("/")
     * @Template()
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return [];
    }

}
