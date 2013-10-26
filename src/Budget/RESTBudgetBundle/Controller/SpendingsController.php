<?php

namespace Budget\RESTBudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Templating\Helper\Helper;
use FOS\RestBundle\Controller\Annotations\View;

class SpendingsController extends \Budget\RESTBudgetBundle\Controller\Helper\RESTController
{

    /**
     * @View(serializerGroups={"Spending"})
     *
     * @return mixed
     */
    public function getSpendingsAction()
    {
        throw new \Exception('Incorrect method! You should specify which spendings to get!');
    }

    /**
     * @View(serializerGroups={"Spending"})
     *
     * @return mixed
     */
    public function getSpendingAction($id)
    {
        return $this->get('r.spending')->findOneById($id);
    }

    /**
     * @View(serializerGroups={"Spending"})
     *
     * @return mixed
     */
    public function postSpendingsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->get('r.spending')->newEntity();

        $editForm = $this->createForm(new \Budget\BudgetBundle\Form\SpendingsType(), $entity, array('method' => "POST"));
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
     * @View(serializerGroups={"Spending"})
     *
     * @return mixed
     */
    public function putSpendingAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->get('r.spending')->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Spending entity.');
        }

        $editForm = $this->createForm(new \Budget\BudgetBundle\Form\SpendingsType(), $entity, array('method' => "PUT"));
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
     * @View(serializerGroups={"Spending"})
     *
     * @return mixed
     */
    public function deleteSpendingAction($id)
    {
        $entity = $this->get('r.spending')->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Spending entity.');
        }

        $em = $this->get('em');

        $em->remove($entity);
        $em->flush();

        return $entity;
    }

}
