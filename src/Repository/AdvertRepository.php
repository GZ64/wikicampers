<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Advert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Advert>
 *
 * @method Advert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advert[]    findAll()
 * @method Advert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvertRepository extends ServiceEntityRepository
{
	public static int $LIMIT = 9;
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Advert::class);
    }
	
	public function paginateAdverts(int $page, $adverts): PaginationInterface {
		return $this->paginator->paginate(
			$adverts,
			$page,
			self::$LIMIT,
			[
				'distinct' => true,
				'sortFieldAllowList' => ['a.id']
			]
		);
	}
	
	public function findSearch(SearchData $search): array {
		$query = $this
			->createQueryBuilder('a')
			->select('e', 'a')
			->select('t', 'a')
			->join('a.equipment', 'e')
			->join('a.thumbnails', 't');
		
		if (!empty($search->q)) {
			$query = $query
				->andWhere('a.title LIKE :q')
				->setParameter('q', "%{$search->q}%");
		}
		if (!empty($search->city)) {
			$query = $query
				->andWhere('a.city LIKE :city')
				->setParameter('city', $search->city);
		}
		if (!empty($search->pricePerDayMin)) {
			$query = $query
				->andWhere('a.pricePerDay >= :pricePerDayMin')
				->setParameter('pricePerDayMin', $search->pricePerDayMin);
		}
		if (!empty($search->pricePerDayMax)) {
			$query = $query
				->andWhere('a.pricePerDay <= :pricePerDayMax')
				->setParameter('pricePerDayMax', $search->pricePerDayMax);
		}
		if (!empty($search->availability)) {
			$query = $query
				->andWhere('a.availability <= :availability')
				->setParameter('availability', $search->availability);
		}
		if(!empty($search->equipment)) {
			$query = $query
				->andWhere('e.id IN (:equipment)')
				->setParameter('equipment', $search->equipment);
		}
		if(!empty($search->campingCarSize)) {
			$query = $query
				->andWhere('a.campingCarSize >= :campingCarSize')
				->setParameter('campingCarSize', $search->campingCarSize);
		}
		return $query->getQuery()->getResult();
	}

    //    /**
    //     * @return Advert[] Returns an array of Advert objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Advert
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
