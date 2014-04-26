<?php

namespace Checkman\RESTCheckmanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Templating\Helper\Helper;
use FOS\RestBundle\Controller\Annotations\View;

class ProjectInvolvementController extends \Checkman\RESTCheckmanBundle\Controller\Helper\RESTController
{

    /**
     * @View(serializerGroups={"ProjectInvolvement"})
     *
     * @return mixed
     */
    public function getInvolvementsAction()
    {
        return $this->get('r.project_involvement')->findAll();
    }

    /**
     * @View(serializerGroups={"ProjectInvolvement"})
     *
     * @return mixed
     */
    public function getInvolvementAction($id)
    {
        return $this->get('r.project_involvement')->findOneById($id);
    }

    /**
     * @View(serializerGroups={"ProjectInvolvement"})
     *
     * @return mixed
     */
    public function postInvolvementsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->get('r.project_involvement')->newEntity();

        $editForm = $this->createForm(new \Checkman\CheckmanBundle\Form\ProjectInvolvementType(), $entity, array('method' => "POST"));
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
     * @View(serializerGroups={"ProjectInvolvement"})
     *
     * @return mixed
     */
    public function putInvolvementAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->get('r.project_involvement')->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        $editForm = $this->createForm(new \Checkman\CheckmanBundle\Form\ProjectInvolvementType(), $entity, array('method' => "PUT"));
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
     * @View(serializerGroups={"ProjectInvolvement"})
     *
     * @return mixed
     */
    public function deleteInvolvementAction($id)
    {
        $entity = $this->get('r.project_involvement')->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProjectInvolvement entity.');
        }

        $em = $this->get('em');

        $em->remove($entity);
        $em->flush();

        return $entity;
    }

}
