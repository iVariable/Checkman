<?php

namespace Budget\RESTBudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Templating\Helper\Helper;
use FOS\RestBundle\Controller\Annotations\View;

class EmployeeController extends \Budget\RESTBudgetBundle\Controller\Helper\RESTController
{

    /**
     * @View(serializerGroups={"Employee"})
     *
     * @return mixed
     */
    public function getEmployeesAction()
    {
        $employees = $this->get('r.employee')->findAll();

        return $employees;
    }

    /**
     * @View(serializerGroups={"Employee"})
     *
     * @return mixed
     */
    public function getEmployeeAction($id)
    {
        return $this->get('r.employee')->findOneById($id);
    }
}
