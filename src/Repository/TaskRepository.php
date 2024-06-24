<?php

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
