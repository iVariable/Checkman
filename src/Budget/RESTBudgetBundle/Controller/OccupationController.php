<?php

namespace Budget\RESTBudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Templating\Helper\Helper;
use FOS\RestBundle\Controller\Annotations\View;

class OccupationController extends \Budget\RESTBudgetBundle\Controller\Helper\RESTController
{

    /**
     * @View(serializerGroups={"Occupation"})
     *
     * @return mixed
     */
    public function getOccupationsAction()
    {
        return $this->get('r.occupation')->findAll();
    }

    /**
     * @View(serializerGroups={"Occupation"})
     *
     * @return mixed
     */
    public function getOccupationAction($id)
    {
        return $this->get('r.occupation')->findOneById($id);
    }
}
