<?php

namespace App\EntityListener;

use App\Entity\Sujet;
use App\Repository\PostRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(
    event: Events::preRemove,
    entity: Sujet::class
)]
class SujetRemovePostListener
{
    private PostRepository $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function preRemove(Sujet $sujet): void
    {
        if (null != $sujet->getPosts()) {
            $posts = $sujet->getPosts();
            foreach ($posts as $post) {
                $this->repository->remove($post);
            }
        }
    }
}