<?php

namespace Zavoca\CoreBundle\Repository;

use Zavoca\CoreBundle\Entity\User;
use Zavoca\CoreBundle\Enums\UserStatus;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends \App\RepositoryZavoca\UserRepository
{

    public function findOnlineUsers($lazy = false)
    {
        $qb = $this->createQueryBuilder('u')
            ->andWhere('u.lastActive > :date')
            ->setParameter('date', new \DateTime('5 minutes ago'));
        if ($lazy) {
            $qb->select('u.id');
        }
        $qb = $qb->getQuery();

        return $qb->execute();
    }

    public function findTotalActiveUsers($lazy = false)
    {
        $qb = $this->createQueryBuilder('u')
            ->andWhere('u.status = :status')
            ->setParameter('status', UserStatus::ACTIVE);

        if ($lazy) {
            $qb->select('u.id');
        }

        $qb = $qb->getQuery();

        return $qb->execute();
    }

    public function findUsersCreatedByMonth($delay = null, $lazy = false)
    {
        // if you want for a month specific '-1 month'

        $start = new \DateTime('first day of this month');
        $end = new \DateTime('last day of this month');

        $start->setTime(0, 0,0);
        $end->setTime(24,59,59);

        if ($delay !== null) {
            $start->modify($delay);
            $end->modify($delay);
            $end->modify('last day of this month');
        }

        $qb = $this->createQueryBuilder('u')
            ->andWhere('u.createdAt >= :date')
            ->andWhere('u.createdAt < :dateEnd')
            ->setParameter('date', $start)
            ->setParameter('dateEnd', $end)
            ->andWhere('u.status != :status')
            ->setParameter('status', UserStatus::ARCHIVED);

        if ($lazy) {
            $qb->select('u.id');
        }

        $qb = $qb->getQuery();

        return $qb->execute();
    }
}
