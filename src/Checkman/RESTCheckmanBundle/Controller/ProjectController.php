<?php

namespace Checkman\RESTCheckmanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Templating\Helper\Helper;
use FOS\RestBundle\Controller\Annotations\View;

class ProjectController extends \Checkman\RESTCheckmanBundle\Controller\Helper\RESTController
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

    /**
     * @View(serializerGroups={"Project"})
     *
     * @return mixed
     */
    public function postProjectsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->get('r.project')->newEntity();

        $editForm = $this->createForm(new \Checkman\CheckmanBundle\Form\ProjectType(), $entity, array('method' => "POST"));
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
     * @View(serializerGroups={"Project"})
     *
     * @return mixed
     */
    public function putProjectAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->get('r.project')->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        $editForm = $this->createForm(new \Checkman\CheckmanBundle\Form\ProjectType(), $entity, array('method' => "PUT"));
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
     * @View(serializerGroups={"Project"})
     *
     * @return mixed
     */
    public function deleteProjectAction($id)
    {
        $entity = $this->get('r.project')->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        $em = $this->get('em');

        $em->remove($entity);
        $em->flush();

        return $entity;
    }

}
