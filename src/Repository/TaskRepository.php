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

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

class TaskRepository extends ManagerRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function fetchWithPagination(int $page, int $limit, ?User $user = null)
    {
        $qb = $this->createQueryBuilder('tasks');
        $qb->innerJoin('tasks.user', 'user');

        $qb->select(['tasks.id', 'tasks.title', 'tasks.description', 'tasks.status', 'tasks.createdAt', 'user.firstName', 'user.lastName', 'user.email']);

        if ($user) {
            $qb->andWhere('user = :user')->setParameter('user', $user);
        }

        $qb->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        return $qb->getQuery()->getArrayResult();
    }

    public function findById(int $id): ?Task
    {
        $qb = $this->createQueryBuilder('tasks');
        $qb->innerJoin('tasks.user', 'user');

        $qb->select(['tasks.id', 'tasks.title', 'tasks.description', 'tasks.status', 'tasks.createdAt', 'user.firstName', 'user.lastName', 'user.email']);

        $qb->andWhere('tasks.id = :id')->setParameter('id', $id);

        return $qb->getQuery()->getArrayResult();
    }
}
