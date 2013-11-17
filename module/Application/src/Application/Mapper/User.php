<?php
namespace Application\Mapper;

use Doctrine\ORM\EntityRepository;


class User extends EntityRepository
{
    public function fetchSortable($field, $type = 'ASC')
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select(array('u', 'p'))
            ->innerJoin('u.profile', 'p')
            ->orderBy($field, $type)
        ;
        return $qb->getQuery()->getResult();
    }
}