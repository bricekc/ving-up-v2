<?php

namespace App\EntityListener;

use App\Entity\Rubrique;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\Filesystem\Filesystem;
use Vich\UploaderBundle\Storage\StorageInterface;

#[AsEntityListener(
    event: Events::preRemove,
    entity: Rubrique::class,
)]
class RubriqueRemoveListener
{
    private StorageInterface $storage;
    private Filesystem $filesystem;

    public function __construct(StorageInterface $storage, Filesystem $filesystem)
    {
        $this->storage = $storage;
        $this->filesystem = $filesystem;
    }

    public function preRemove(Rubrique $rubrique)
    {
        $file = $rubrique->getFile();

        if ($file) {
            $filePath = $this->storage->resolvePath($file);
            if ($this->filesystem->exists($filePath)) {
                $this->filesystem->remove($filePath);
            }
        }
    }
}
