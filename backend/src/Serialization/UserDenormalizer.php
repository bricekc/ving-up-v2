<?php

namespace App\Serialization;

use App\Entity\Fournisseur;
use App\Entity\Viticulteur;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;

class UserDenormalizer implements \Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface, \Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    private const ALREADY_CALLED = 'USER_DENORMALIZER_ALREADY_CALLED';

    private UserPasswordHasherInterface $passwordHasher;
    private Security $security;

    public function __construct(UserPasswordHasherInterface $passwordHasher, Security $security)
    {
        $this->passwordHasher = $passwordHasher;
        $this->security = $security;
    }

    public function supportsDenormalization($data, string $type, string $format = null, array $context = []): bool
    {
        return !isset($context[self::ALREADY_CALLED]);
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $context[self::ALREADY_CALLED] = true;

        if (isset($data['password'])) {
            if (null == $this->security->getUser())
            {
                if (isset($data['num_siret']))
                {
                    $user = new Viticulteur();
                    $user->setEmail($data['email']);
                    $user->setFirstname($data['firstname']);
                    $user->setLastname($data['lastname']);
                    $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));
                    $user->setAdresse($data['adresse']);
                    $user->setCp($data['cp']);
                    $user->setVille($data['ville']);
                    $user->setNumSiret($data['num_siret']);
                }
                else
                {
                    $user = new Fournisseur();
                    $user->setEmail($data['email']);
                    $user->setFirstname($data['firstname']);
                    $user->setLastname($data['lastname']);
                    $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));
                    $user->setAdresse($data['adresse']);
                    $user->setCp($data['cp']);
                    $user->setVille($data['ville']);
                }
            }
            else
            {
                $data['password'] = $this->passwordHasher->hashPassword($this->security->getUser(), $data['password']);
            }
        }

        return $this->denormalizer->denormalize($data, $type, $format, $context);
    }
}
