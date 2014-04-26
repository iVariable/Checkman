<?php

namespace Checkman\CheckmanBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Checkman\CheckmanBundle\Entity\Occupation;
use Checkman\CheckmanBundle\Form\OccupationType;

/**
 * Occupation controller.
 *
 * @Route("/crud/occupation")
 */
class OccupationController extends Controller
{

    /**
     * Lists all Occupation entities.
     *
     * @Route("/", name="crud_occupation")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CheckmanBundle:Occupation')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Occupation entity.
     *
     * @Route("/", name="crud_occupation_create")
     * @Method("POST")
     * @Template("CheckmanBundle:Occupation:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Occupation();
        $form = $this->createForm(new OccupationType(), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('crud_occupation_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Occupation entity.
     *
     * @Route("/new", name="crud_occupation_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Occupation();
        $form   = $this->createForm(new OccupationType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Occupation entity.
     *
     * @Route("/{id}", name="crud_occupation_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CheckmanBundle:Occupation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Occupation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Occupation entity.
     *
     * @Route("/{id}/edit", name="crud_occupation_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CheckmanBundle:Occupation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Occupation entity.');
        }

        $editForm = $this->createForm(new OccupationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Occupation entity.
     *
     * @Route("/{id}", name="crud_occupation_update")
     * @Method("PUT")
     * @Template("CheckmanBundle:Occupation:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CheckmanBundle:Occupation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Occupation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new OccupationType(), $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('crud_occupation_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Occupation entity.
     *
     * @Route("/{id}", name="crud_occupation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CheckmanBundle:Occupation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Occupation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('crud_occupation'));
    }

    /**
     * Creates a form to delete a Occupation entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
