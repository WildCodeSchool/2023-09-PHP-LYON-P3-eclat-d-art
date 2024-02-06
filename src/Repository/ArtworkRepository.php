<?php

namespace App\Repository;

use App\Entity\Artwork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Artwork>
 *
 * @method Artwork|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artwork|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artwork[]    findAll()
 * @method Artwork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtworkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artwork::class);
    }


    public function findRandomImages(): array
    {
        $entityManager = $this->getEntityManager();
        $totalArtworks = $entityManager
        ->createQuery('SELECT COUNT(a.id) FROM App\Entity\Artwork a')
        ->getSingleScalarResult();

        $maxOffset = max(0, $totalArtworks - 3);

        $offset = rand(0, $maxOffset);

        $queryBuilder = $this->createQueryBuilder('a')
        ->setFirstResult($offset)
        ->setMaxResults(3)
        ->getQuery();

        return $queryBuilder->getResult();
    }

    public function findImagesByUser(int $userId): array
    {
        $entityManager = $this->getEntityManager();
        $totalArtworks = $entityManager
            ->createQuery('SELECT COUNT(a.id) FROM App\Entity\Artwork a WHERE a.user = :userId')
            ->setParameter('userId', $userId)
            ->getSingleScalarResult();

        $maxOffset = max(0, $totalArtworks - 3);

        $offset = rand(0, $maxOffset);

        $queryBuilder = $this->createQueryBuilder('a')
            ->andWhere('a.user = :userId')
            ->setParameter('userId', $userId)
            ->setFirstResult($offset)
            ->setMaxResults(3)
            ->getQuery();

        return $queryBuilder->getResult();
    }
    
    public function searchByQuery(string $query): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.title LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }

    public function findAllByOrderDesc(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.updatedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
