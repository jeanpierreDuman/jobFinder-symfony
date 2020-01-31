<?php

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Job::class);
    }

    public function search($dataSearch)
    {
        $dataSearch = $this->removeUselessData($dataSearch);

        if($dataSearch === null) {
            $dataSearch = [];
        }

        $request = $this->createQueryBuilder('j');

        foreach($dataSearch as $key => $data) {
            if($data !== '') {
                $request->andWhere('j.' . $key . ' = :' . $key)
                        ->setParameter(':'. $key, $data);
            }
        }

        return $request->getQuery()->getResult();
    }

    private function removeUselessData($array)
    {
        unset($array['save']);
        unset($array['_token']);

        return $array;
    }
}
