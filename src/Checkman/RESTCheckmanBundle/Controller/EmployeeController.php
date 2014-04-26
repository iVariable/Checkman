<?php

namespace Checkman\RESTCheckmanBundle\Controller;

use Checkman\CheckmanBundle\Entity\Employee;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Templating\Helper\Helper;
use FOS\RestBundle\Controller\Annotations\View;

class EmployeeController extends \Checkman\RESTCheckmanBundle\Controller\Helper\RESTController
{

    /**
     * @View(serializerGroups={"Employee", "Occupation", "ProjectInvolvement"})
     *
     * @return mixed
     */
    public function getEmployeesAction()
    {
        $employees = $this->get('r.employee')->findAll();

        return $employees;
    }

    /**
     * @View(serializerGroups={"Employee", "Occupation", "ProjectInvolvement"})
     *
     * @return mixed
     */
    public function getEmployeeAction($id)
    {
        return $this->get('r.employee')->findOneById($id);
    }

    /**
     * @View()
     *
     * @return mixed
     */
    public function getEmployeeProjectshistoryAction($id)
    {
        $data = $this->get('checkman.history')->getEmployeeProjectsHistory($id);

        return $data;
    }

    /**
     * @View(serializerGroups={"Employee", "Occupation", "ProjectInvolvement"})
     *
     * @return mixed
     */
    public function postEmployeesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->get('r.employee')->newEntity();

        $editForm = $this->createForm(new \Checkman\CheckmanBundle\Form\EmployeeType(), $entity, array('method' => "POST"));
        $editForm->handleRequest($this->getRequest());

        if ($editForm->isValid()) {
            $this->processInvolvements($entity, $this->getRequest()->get('involvementsDiff'));
            $em->persist($entity);
            $em->flush();
        } else {
            return $editForm->getErrorsAsString();
        }

        return $entity;
    }

    /**
     * @View(serializerGroups={"Employee", "Occupation", "ProjectInvolvement"})
     *
     * @return mixed
     */
    public function putEmployeeAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        /* @var $entity \Checkman\CheckmanBundle\Entity\Employee */
        $entity = $this->get('r.employee')->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Employee entity.');
        }

        $editForm = $this->createForm(new \Checkman\CheckmanBundle\Form\EmployeeType(), $entity, array('method' => "PUT"));
        $editForm->handleRequest($this->getRequest());

        if ($editForm->isValid()) {
            $this->processInvolvements($entity, $this->getRequest()->get('involvementsDiff'));
            $em->persist($entity);
            $em->flush();
        } else {
            return $editForm->getErrorsAsString();
        }

        return $entity;
    }

    /**
     * @View(serializerGroups={"Employee", "Occupation", "ProjectInvolvement"})
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

    /**
     * @param Employee $employee
     * @param null $involvementsRaw
     * @return Employee
     */
    protected function processInvolvements(Employee $employee, $involvementsRaw = null)
    {
        if($involvementsRaw === null) return;
        $em = $this->get('em');
        $currentInvolvements = $employee->getProjectInvolvements();

        if ($involvementsRaw) {
            foreach ($currentInvolvements as $involvement) {
                $delete = true;
                foreach ($involvementsRaw as $involvementRaw) {
                    if (!isset($involvementRaw['id']) || !$involvementRaw['id']) {
                        continue;
                    }
                    if ($involvementRaw['id'] == $involvement->getId()) {
                        $delete = false;
                        break;
                    }
                }
                if ($delete) {
                    $em->remove($involvement);
                }
            }

            foreach ($involvementsRaw as $involvementRaw) {
                /* @var $involvement \Checkman\CheckmanBundle\Entity\ProjectInvolvement */
                $involvement = null;
                if (isset($involvementRaw['id']) && $involvementRaw['id']) {
                    foreach ($currentInvolvements as $currentInvolvement) {
                        if($currentInvolvement->getId() == $involvementRaw['id']){
                            $involvement = $currentInvolvement;
                            break;
                        }
                    }
                } else {
                    $involvement = $this->get('r.project_involvement')->newEntity();

                    $project = $this->get('r.project')->findOneById($involvementRaw['project']);
                    $involvement->setProject($project);

                }

                if ($involvement === null) {
                    throw new \Exception('Project involvement not found!');
                }

                $involvement->setEmployee($employee);
                $involvement->setInvolvement($involvementRaw['involvement']);
                $involvement->setNotes($involvementRaw['notes']);

                $employee->addProjectInvolvement($involvement);

                $em->persist($involvement);
            }

        } else {
            foreach ($currentInvolvements as $involvement) {
                $em->remove($involvement);
            }
        }

        //persist must be called in the outer/caller method
        return $employee;
    }

}
