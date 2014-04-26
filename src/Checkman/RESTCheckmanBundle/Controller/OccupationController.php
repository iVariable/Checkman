<?php

namespace Checkman\RESTCheckmanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Templating\Helper\Helper;
use FOS\RestBundle\Controller\Annotations\View;

class OccupationController extends \Checkman\RESTCheckmanBundle\Controller\Helper\RESTController
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

    /**
     * @View(serializerGroups={"Occupation"})
     *
     * @return mixed
     */
    public function postOccupationsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->get('r.occupation')->newEntity();

        $editForm = $this->createForm(new \Checkman\CheckmanBundle\Form\OccupationType(), $entity, array('method' => "POST"));
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
     * @View(serializerGroups={"Occupation"})
     *
     * @return mixed
     */
    public function putOccupationAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->get('r.occupation')->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Occupation entity.');
        }

        $editForm = $this->createForm(new \Checkman\CheckmanBundle\Form\OccupationType(), $entity, array('method' => "PUT"));
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
     * @View(serializerGroups={"Occupation"})
     *
     * @return mixed
     */
    public function deleteOccupationAction($id)
    {
        $entity = $this->get('r.occupation')->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Occupation entity.');
        }

        $em = $this->get('em');

        $em->remove($entity);
        $em->flush();

        return $entity;
    }

}
