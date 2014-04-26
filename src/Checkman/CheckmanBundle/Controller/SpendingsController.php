<?php

namespace Checkman\CheckmanBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Checkman\CheckmanBundle\Entity\Spendings;
use Checkman\CheckmanBundle\Form\SpendingsType;

/**
 * Spendings controller.
 *
 * @Route("/crud/spendings")
 */
class SpendingsController extends Controller
{

    /**
     * Lists all Spendings entities.
     *
     * @Route("/", name="crud_spendings")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CheckmanBundle:Spendings')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Spendings entity.
     *
     * @Route("/", name="crud_spendings_create")
     * @Method("POST")
     * @Template("CheckmanBundle:Spendings:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Spendings();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('crud_spendings_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Spendings entity.
    *
    * @param Spendings $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Spendings $entity)
    {
        $form = $this->createForm(new SpendingsType(), $entity, array(
            'action' => $this->generateUrl('crud_spendings_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Spendings entity.
     *
     * @Route("/new", name="crud_spendings_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Spendings();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Spendings entity.
     *
     * @Route("/{id}", name="crud_spendings_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CheckmanBundle:Spendings')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Spendings entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Spendings entity.
     *
     * @Route("/{id}/edit", name="crud_spendings_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CheckmanBundle:Spendings')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Spendings entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Spendings entity.
    *
    * @param Spendings $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Spendings $entity)
    {
        $form = $this->createForm(new SpendingsType(), $entity, array(
            'action' => $this->generateUrl('crud_spendings_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Spendings entity.
     *
     * @Route("/{id}", name="crud_spendings_update")
     * @Method("PUT")
     * @Template("CheckmanBundle:Spendings:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CheckmanBundle:Spendings')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Spendings entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('crud_spendings_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Spendings entity.
     *
     * @Route("/{id}", name="crud_spendings_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CheckmanBundle:Spendings')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Spendings entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('crud_spendings'));
    }

    /**
     * Creates a form to delete a Spendings entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('crud_spendings_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
