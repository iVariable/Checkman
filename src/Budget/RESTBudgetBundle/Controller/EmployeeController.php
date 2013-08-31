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
     * @View(serializerGroups={"Employee", "Occupation"})
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

    /**
     * @View(serializerGroups={"Employee"})
     *
     * @return mixed
     */
    public function postEmployeesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->get('r.employee')->newEntity();

        $editForm = $this->createForm(new \Budget\BudgetBundle\Form\EmployeeType(), $entity, array('method' => "POST"));
        $editForm->handleRequest($this->getRequest());

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
        } else {
            return $editForm->getErrorsAsString();
        }

        return $entity;
    }

    /**
     * @View(serializerGroups={"Employee"})
     *
     * @return mixed
     */
    public function putEmployeeAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->get('r.employee')->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employee entity.');
        }

        $editForm = $this->createForm(new \Budget\BudgetBundle\Form\EmployeeType(), $entity, array('method' => "PUT"));
        $editForm->handleRequest($this->getRequest());

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
        } else {
            return $editForm->getErrorsAsString();
        }

        return $entity;
    }

    /**
     * @View(serializerGroups={"Employee"})
     *
     * @return mixed
     */
    public function deleteEmployeeAction($id)
    {
        $entity = $this->get('r.employee')->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employee entity.');
        }

        $em = $this->get('em');

        $em->remove($entity);
        $em->flush();

        return $entity;
    }

}
