<?php

namespace Budget\RESTBudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Templating\Helper\Helper;
use FOS\RestBundle\Controller\Annotations\View;

class ProjectController extends \Budget\RESTBudgetBundle\Controller\Helper\RESTController
{

    /**
     * @View(serializerGroups={"Project"})
     *
     * @return mixed
     */
    public function getProjectsAction()
    {
        return $this->get('r.project')->findAll();
    }

    /**
     * @View(serializerGroups={"Project"})
     *
     * @return mixed
     */
    public function getProjectAction($id)
    {
        return $this->get('r.project')->findOneById($id);
    }
}
