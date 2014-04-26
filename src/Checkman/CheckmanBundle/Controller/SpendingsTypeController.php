<?php

namespace Checkman\CheckmanBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Checkman\CheckmanBundle\Entity\SpendingsType;
use Checkman\CheckmanBundle\Form\SpendingsTypeType;

/**
 * SpendingsType controller.
 *
 * @Route("/crud/spendings_type")
 */
class SpendingsTypeController extends Controller
{

    /**
     * Lists all SpendingsType entities.
     *
     * @Route("/", name="crud_spendings_type")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CheckmanBundle:SpendingsType')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new SpendingsType entity.
     *
     * @Route("/", name="crud_spendings_type_create")
     * @Method("POST")
     * @Template("CheckmanBundle:SpendingsType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SpendingsType();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('crud_spendings_type_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a SpendingsType entity.
    *
    * @param SpendingsType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(SpendingsType $entity)
    {
        $form = $this->createForm(new SpendingsTypeType(), $entity, array(
            'action' => $this->generateUrl('crud_spendings_type_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SpendingsType entity.
     *
     * @Route("/new", name="crud_spendings_type_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SpendingsType();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a SpendingsType entity.
     *
     * @Route("/{id}", name="crud_spendings_type_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CheckmanBundle:SpendingsType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpendingsType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SpendingsType entity.
     *
     * @Route("/{id}/edit", name="crud_spendings_type_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CheckmanBundle:SpendingsType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpendingsType entity.');
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
    * Creates a form to edit a SpendingsType entity.
    *
    * @param SpendingsType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SpendingsType $entity)
    {
        $form = $this->createForm(new SpendingsTypeType(), $entity, array(
            'action' => $this->generateUrl('crud_spendings_type_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing SpendingsType entity.
     *
     * @Route("/{id}", name="crud_spendings_type_update")
     * @Method("PUT")
     * @Template("CheckmanBundle:SpendingsType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CheckmanBundle:SpendingsType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SpendingsType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('crud_spendings_type_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a SpendingsType entity.
     *
     * @Route("/{id}", name="crud_spendings_type_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CheckmanBundle:SpendingsType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SpendingsType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('crud_spendings_type'));
    }

    /**
     * Creates a form to delete a SpendingsType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('crud_spendings_type_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
