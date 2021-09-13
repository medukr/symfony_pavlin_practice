<?php


namespace App\Repository;


use App\Entity\Post;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface PostRepositoryInterface
{
    /**
     * @return Post[]
     */
    public function getAllPost(): array;

    /**
     * @param int $id
     * @return Post
     */
    public function getOnePost(int $id): Post;

    /**
     * @param Post $post
     * @param UploadedFile $file
     * @return Post
     */
    public function setCreatePost(Post $post, UploadedFile $file): Post;

    /**
     * @param Post $post
     * @param UploadedFile $file
     * @return Post
     */
    public function setUpdatePost(Post $post, UploadedFile $file): Post;

    /**
     * @param Post $post
     * @param string $fileName
     */
    public function setDeletePost(Post $post, string $fileName): void;
}