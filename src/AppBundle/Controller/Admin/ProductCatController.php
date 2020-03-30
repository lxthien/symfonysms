<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Form\ProductCatType;
use AppBundle\Entity\ProductCat;
use AppBundle\Utils\Slugger;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/productcat")
 * @Security("has_role('ROLE_ADMIN')")
 */

class ProductCatController extends Controller
{
    /**
     * @Route("/", name="admin_productcat_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $objects = $em->getRepository(ProductCat::class)->findAll();

        return $this->render('admin/productcat/index.html.twig', [
            'objects' => $objects
        ]);
    }

    /**
     * @Route("/new", name="admin_productcat_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Slugger $slugger)
    {
        $category = new ProductCat();
        $category->setAuthor($this->getUser());

        $form = $this->createForm(ProductCatType::class, $category)
            ->add('saveAndCreateNew', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'action.created_successfully');

            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('admin_productcat_new');
            }

            return $this->redirectToRoute('admin_productcat_index');
        }

        return $this->render('admin/productcat/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="admin_productcat_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ProductCat $category, Slugger $slugger)
    {
        $form = $this->createForm(ProductCatType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'action.updated_successfully');
            return $this->redirectToRoute('admin_productcat_index');
        }

        return $this->render('admin/productcat/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", methods={"POST"}, name="admin_productcat_delete")
     */
    public function deleteAction(Request $request, ProductCat $category)
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_productcat_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        $this->addFlash('success', 'action.deleted_successfully');

        return $this->redirectToRoute('admin_productcat_index');
    }
}
