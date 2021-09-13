<?php


namespace App\Repository;


use App\Entity\Category;

interface CategoryRepositoryInterface
{
    /**
     * @return Category[]
     */
    public function getAllCategory(): array;

    /**
     * @param int $id
     * @return Category
     */
    public function getOneCategory(int $id): Category;

    /**
     * @param Category $category
     * @return Category
     */
    public function setCreateCategory(Category $category): Category;

    /**
     * @param Category $category
     * @return Category
     */
    public function setUpdateCategory(Category $category): Category;

    /**
     * @param Category $category
     */
    public function setDeleteCategory(Category $category): void;
}