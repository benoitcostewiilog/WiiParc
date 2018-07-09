<?php

namespace App\Repository;

use App\Entity\Affectations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Affectations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Affectations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Affectations[]    findAll()
 * @method Affectations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffectationsRepository extends ServiceEntityRepository
{
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, Affectations::class);
	}

	public function findXtoY($page = 1, $nbPerPage = 30)
	{
		$query=$this->createQueryBuilder('a')
			->innerJoin('a.parc', 'c')
			->addSelect('c')
			->orderBy('a.dentree', 'DESC')
			->getQuery()
		;
		$query
		->setFirstResult(($page - 1) * $nbPerPage)
		->setMaxResults($nbPerPage)
		;
		return new Paginator($query, true);
	}

	public function findParcAffectations($Nparc)
	{
		return $this
			->createQueryBuilder('a')
			->where('a.id = :id')
			->setParameter('id', $Nparc)
			->getQuery()
			->getResult()
		;
	}

//    /**
//     * @return Affectations[] Returns an array of Affectations objects
//     */
	/*
	public function findByExampleField($value)
	{
		return $this->createQueryBuilder('a')
			->andWhere('a.exampleField = :val')
			->setParameter('val', $value)
			->orderBy('a.id', 'ASC')
			->setMaxResults(10)
			->getQuery()
			->getResult()
		;
	}
	*/

	/*
	public function findOneBySomeField($value): ?Affectations
	{
		return $this->createQueryBuilder('a')
			->andWhere('a.exampleField = :val')
			->setParameter('val', $value)
			->getQuery()
			->getOneOrNullResult()
		;
	}
	*/
}
