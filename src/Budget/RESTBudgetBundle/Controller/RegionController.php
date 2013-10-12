<?php

namespace Budget\RESTBudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Templating\Helper\Helper;
use FOS\RestBundle\Controller\Annotations\View;

class RegionController extends \Budget\RESTBudgetBundle\Controller\Helper\RESTController
{

    /**
     * @View(serializerGroups={"Region"})
     *
     * @return mixed
     */
    public function getRegionsAction()
    {
        return $this->get('r.region')->findAll();
    }

    /**
     * @View(serializerGroups={"Region"})
     *
     * @return mixed
     */
    public function getRegionAction($id)
    {
        return $this->get('r.region')->findOneById($id);
    }

    /**
     * @View(serializerGroups={"Region"})
     *
     * @return mixed
     */
    public function postRegionsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->get('r.region')->newEntity();

        $editForm = $this->createForm(new \Budget\BudgetBundle\Form\RegionType(), $entity, array('method' => "POST"));
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
     * @View(serializerGroups={"Region"})
     *
     * @return mixed
     */
    public function putRegionAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->get('r.region')->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Region entity.');
        }

        $editForm = $this->createForm(new \Budget\BudgetBundle\Form\RegionType(), $entity, array('method' => "PUT"));
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
     * @View(serializerGroups={"Region"})
     *
     * @return mixed
     */
    public function deleteRegionAction($id)
    {
        $entity = $this->get('r.region')->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Region entity.');
        }

        $em = $this->get('em');

        $em->remove($entity);
        $em->flush();

        return $entity;
    }

}
