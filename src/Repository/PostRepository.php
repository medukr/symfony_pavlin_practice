<?php

namespace App\Repository;

use App\Entity\Post;
use App\Service\FileManagerServiceInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $registry;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    /**
     * @var FileManagerServiceInterface
     */
    private FileManagerServiceInterface $fileManagerService;

    public function __construct(ManagerRegistry $registry,
                                EntityManagerInterface $manager,
                                FileManagerServiceInterface $fileManagerService)
    {
        parent::__construct($registry, Post::class);

        $this->registry = $registry;
        $this->manager = $manager;
        $this->fileManagerService = $fileManagerService;
    }

    public function getAllPost(): array
    {
        return parent::findAll();
    }

    public function getOnePost(int $id): Post
    {
        return parent::find($id);
    }

    public function setCreatePost(Post $post, UploadedFile $file): Post
    {
        // TODO: Implement setCreatePost() method.
    }

    public function setUpdatePost(Post $post, UploadedFile $file): Post
    {
        // TODO: Implement setUpdatePost() method.
    }

    public function setDeletePost(Post $post, string $fileName): void
    {
        // TODO: Implement setDeletePost() method.
    }
}
