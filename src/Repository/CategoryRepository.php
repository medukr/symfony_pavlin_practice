<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Category::class);

        $this->manager = $manager;
    }

    public function getAllCategory(): array
    {
        return parent::findAll();
    }

    public function getOneCategory(int $id): Category
    {
        return parent::find($id);
    }

    public function setCreateCategory(Category $category): Category
    {
        $category->setCrateAtValue();
        $category->setUpdateAtValue();
        $category->setIsPublished();

        $this->manager->persist($category);
        $this->manager->flush();

        return $category;
    }

    public function setUpdateCategory(Category $category): Category
    {
        $category->setUpdateAtValue();

        $this->manager->flush();

        return $category;
    }

    public function setDeleteCategory(Category $category): void
    {
        $this->manager->remove($category);
        $this->manager->flush();
    }
}
