<?php

namespace App\EntityListener;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Security;

#[AsEntityListener(
    event: Events::prePersist,
    entity: Post::class,
)]
#[AsEntityListener(
    event: Events::preRemove,
    entity: Post::class,
)]
class PostSetUserListener
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function prePersist(Post $post): void
    {
        if (null === $post->getUser()) {
            if ($this->security->getUser() instanceof User) {
                $post->setUser($this->security->getUser());
                $post->setDate(new \DateTime());
                $post->getSujet()->setDateLastUpdate(new \DateTime());
            }
        }
        $user = $post->getUser();

        $user->setNbPost($user->getNbPost() + 1);
    }

    public function preRemove(Post $post): void
    {
        $user = $post->getUser();

        $user->setNbPost($user->getNbPost() - 1);
    }
}
