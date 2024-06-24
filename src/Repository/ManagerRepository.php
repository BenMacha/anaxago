<?php

/**
 * PHP version 8.2 & Symfony 6.4.
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * https://www.php.net/license/3_01.txt.
 *
 * developed by Ben Macha.
 *
 * @category   Symfony Project ANAXAGOS
 *
 * @author     Ali BEN MECHA       <contact@benmacha.tn>
 *
 * @copyright  Ⓒ 2024 benmacha.tn
 *
 * @see       https://www.benmacha.tn
 *
 *
 */

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
