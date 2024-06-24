<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

abstract class ManagerRepository extends ServiceEntityRepository
{
    protected ManagerRegistry $registry;
    protected string $entityClass;

    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        $this->registry = $registry;
        $this->entityClass = $entityClass;

        parent::__construct($registry, $entityClass);
    }

    public function remove(object $object): void
    {
        $this->registry->getManager()->remove($object);
    }

    public function resetManager(?string $name = null): void
    {
        $this->registry->resetManager($name);
    }

    public function persist(object $object): void
    {
        $this->registry->getManager()->persist($object);
    }

    public function flush(): void
    {
        $this->registry->getManager()->flush();
    }

    public function save(object $object): void
    {
        $this->persist($object);
        $this->flush();
    }
}
