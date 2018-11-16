<?php

namespace App\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use App\Entity\Article;
use App\Service\FileUploader;

class PhotoUploadListener
{
    private $uploader;

    public function __construct(ContainerInterface $container)
    {
        $uploader = new FileUploader($container->getParameter("images_directory"));
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

//    public function postLoad(LifecycleEventArgs $args)
//    {
//        $entity = $args->getEntity();
//
//        if (!$entity instanceof Article) {
//            return;
//        }
//
//        if ($$entity->getPhoto()) {
//            $fileName = md5(uniqid());
//            $entity->setPhoto(new File($this->uploader->getTargetDirectory().'/'.$fileName));
//        }
//    }

    private function uploadFile($entity)
    {
// upload only works for Article entities
        if (!$entity instanceof Article) {
            return;
        }

        $file = $entity->getPhoto();

// only upload new files
        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
            $entity->setPhoto($fileName);
        } elseif ($file instanceof File) {
// prevents the full file path being saved on updates
// as the path is set on the postLoad listener
            $entity->setPhoto($file->getFilename());
        }
    }
}

?>