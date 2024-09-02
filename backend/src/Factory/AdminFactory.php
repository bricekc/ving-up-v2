<?php

namespace App\Factory;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Admin>
 *
 * @method        Admin|Proxy                     create(array|callable $attributes = [])
 * @method static Admin|Proxy                     createOne(array $attributes = [])
 * @method static Admin|Proxy                     find(object|array|mixed $criteria)
 * @method static Admin|Proxy                     findOrCreate(array $attributes)
 * @method static Admin|Proxy                     first(string $sortedField = 'id')
 * @method static Admin|Proxy                     last(string $sortedField = 'id')
 * @method static Admin|Proxy                     random(array $attributes = [])
 * @method static Admin|Proxy                     randomOrCreate(array $attributes = [])
 * @method static AdminRepository|RepositoryProxy repository()
 * @method static Admin[]|Proxy[]                 all()
 * @method static Admin[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Admin[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static Admin[]|Proxy[]                 findBy(array $attributes)
 * @method static Admin[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Admin[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class AdminFactory extends UserFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        parent::__construct($userPasswordHasher);
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function getDefaults(): array
    {
        return parent::getDefaults();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        /** @var AdminFactory $self */
        $self = parent::initialize();

        return $self;
    }

    protected static function getClass(): string
    {
        return Admin::class;
    }
}
