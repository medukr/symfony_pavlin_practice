<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategotyType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AdminBaseController
{
    /**
     * @Route("/admin/category", name="admin_category")
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)
            ->findAll();


        return $this->render('admin/category/index.html.twig', array_merge($this->renderDefault(), [
            'title' => 'Категории',
            'categories' => $categories
        ]));
    }


    /**
     * @Route("/admin/category/create", name="admin_category_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $category = new Category();
        $form = $this->createForm(CategotyType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setCrateAtValue();
            $category->setUpdateAtValue();
            $category->setIsPublished();

            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'Категория добавлена');

            return $this->redirectToRoute('admin_category');
        }

        return $this->render('admin/category/form.html.twig', array_merge($this->renderDefault(), [
            'title' => 'Создание категории',
            'form' => $form->createView()
        ]));
    }

    /**
     * @Route("/admin/category/update/{id}", name="admin_category_update")
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function update(int $id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $this->getDoctrine()->getRepository(Category::class)
            ->find($id);

        $form = $this->createForm(CategotyType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('save')->isClicked()) {
                $category->setUpdateAtValue();

                $this->addFlash('success', 'Категория обновлена');
            }
            if ($form->get('delete')->isClicked()) {
                $em->remove($category);

                $this->addFlash('success', 'Категория удалена');
            }

            $em->flush();
            return $this->redirectToRoute('admin_category');
        }

        return $this->render('admin/category/form.html.twig', array_merge($this->renderDefault(), [
            'title' => 'Редактирование категории',
            'form' => $form->createView()
        ]));
    }
}
