<?php

namespace App\EntityListener;

use App\Entity\User;
use App\Repository\PostRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(
    event: Events::preRemove,
    entity: User::class
)]
class UserRemovePostListener
{
    private PostRepository $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function preRemove(User $user): void
    {
        if (null != $user->getPosts()) {
            $posts = $user->getPosts();
            foreach ($posts as $post) {
                $this->repository->remove($post);
            }
        }
    }
}
