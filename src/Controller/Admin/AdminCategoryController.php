<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategotyType;
use App\Repository\CategoryRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AdminBaseController
{
    /**
     * @var CategoryRepositoryInterface
     */
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/admin/category", name="admin_category")
     */
    public function index(): Response
    {
        return $this->render('admin/category/index.html.twig', array_merge($this->renderDefault(), [
            'title' => 'Категории',
            'categories' => $this->categoryRepository->getAllCategory()
        ]));
    }


    /**
     * @Route("/admin/category/create", name="admin_category_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategotyType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryRepository->setCreateCategory($category);

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
        $category = $this->categoryRepository->getOneCategory($id);

        $form = $this->createForm(CategotyType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('save')->isClicked()) {
                $this->categoryRepository->setUpdateCategory($category);

                $this->addFlash('success', 'Категория обновлена');
            }
            if ($form->get('delete')->isClicked()) {
                $this->categoryRepository->setDeleteCategory($category);

                $this->addFlash('success', 'Категория удалена');
            }

            return $this->redirectToRoute('admin_category');
        }

        return $this->render('admin/category/form.html.twig', array_merge($this->renderDefault(), [
            'title' => 'Редактирование категории',
            'form' => $form->createView()
        ]));
    }
}
