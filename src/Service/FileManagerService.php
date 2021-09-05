<?php


namespace App\Service;


use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManagerService implements FileManagerServiceInterface
{
    private $postImageDirectory;

    public function __construct($postImageDirectory)
    {
        $this->postImageDirectory = $postImageDirectory;
    }

    public function imagePostUpload(UploadedFile $file): string
    {
        $filename = uniqid() . '.' . $file->getExtension();

        try {
            $file->move($this->getPostImageDirectory(), $filename);
        } catch (FileException $e) {
            return $e;
        }

        return $filename;
    }

    public function removePostImage(string $fileName)
    {
       $fileSystem = new Filesystem();
       $fileImage = $this->getPostImageDirectory() . '/' . $fileName;

        try {
            $fileSystem->remove($fileImage);
        } catch (IOException $e) {
            echo $e->getMessage();
        }

    }

    /**
     * @return mixed
     */
    public function getPostImageDirectory()
    {
        return $this->postImageDirectory;
    }
}