<?php

namespace Checkman\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class DefaultController extends Controller
{

    /**
     *
     * @Route("/")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function defaultAction()
    {
        return $this->redirect($this->generateUrl("start_page", ["_locale" => "en"]));
    }

    /**
     *
     * @Route("/{_locale}/", requirements={"_locale"="en|ru"}, defaults={"_locale" = "en"}, name="start_page")
     * @Template()
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($_locale)
    {
        return [
            "locale" => $_locale == "ru" ? 'root' : $_locale,
            "switchLocaleUrl" => $this->generateUrl('start_page', ['_locale' => ($_locale == "ru")?"en":"ru"])
        ];
    }

}
