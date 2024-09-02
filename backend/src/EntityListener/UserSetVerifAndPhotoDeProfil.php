<?php

namespace App\EntityListener;

use App\Entity\Fournisseur;
use App\Entity\User;
use App\Entity\Viticulteur;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(
    event: Events::prePersist,
    entity: User::class
)]
class UserSetVerifAndPhotoDeProfil
{
    public function prePersist(User $user): void
    {
        if ( get_class($user) == Viticulteur::class || get_class($user) == Fournisseur::class)
        $user->setVerif(false);
        $user->setPhotoProfil(file_get_contents(__DIR__.'/img/default_avatar.png'));
    }
}