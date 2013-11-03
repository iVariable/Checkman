<?php

namespace Budget\RESTBudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Templating\Helper\Helper;
use FOS\RestBundle\Controller\Annotations\View;

class SpendingsTypeController extends \Budget\RESTBudgetBundle\Controller\Helper\RESTController
{

    /**
     * @View(serializerGroups={"SpendingsType"})
     *
     * @return mixed
     */
    public function getSpendingstypesAction()
    {
        $types = $this->get('r.spendings_type')->findAll();
        /**@var $type \Budget\BudgetBundle\Entity\SpendingsType*/
        $type = $this->get('r.spendings_type')->newEntity();
        $type->setId(0);
        $type->setTitle('Затраты на содержание офиса');
        $types[] = $type;
        return $types;
    }

    /**
     * @View(serializerGroups={"SpendingsType"})
     *
     * @return mixed
     */
    public function getSpendingstypeAction($id)
    {
        return $this->get('r.spendings_type')->findOneById($id);
    }

    /**
     * @View(serializerGroups={"SpendingsType"})
     *
     * @return mixed
     */
    public function postSpendingstypesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->get('r.spendings_type')->newEntity();

        $editForm = $this->createForm(new \Budget\BudgetBundle\Form\SpendingsTypeType(), $entity, array('method' => "POST"));
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
     * @View(serializerGroups={"SpendingsType"})
     *
     * @return mixed
     */
    public function putSpendingstypeAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->get('r.spendings_type')->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpendingsType entity.');
        }

        $editForm = $this->createForm(new \Budget\BudgetBundle\Form\SpendingsTypeType(), $entity, array('method' => "PUT"));
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
     * @View(serializerGroups={"SpendingsType"})
     *
     * @return mixed
     */
    public function deleteSpendingstypeAction($id)
    {
        $entity = $this->get('r.spendings_type')->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpendingsType entity.');
        }

        if (!$entity->getCanBeDeleted()){
            throw new AccessDeniedHttpException("This spendings type is delete-protected!");
        }

        $em = $this->get('em');

        $em->remove($entity);
        $em->flush();

        return $entity;
    }

}
