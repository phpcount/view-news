<?php

namespace App\Repository;

use App\Entity\Post;
use App\Exception\PostNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function save(Post $entity): void
    {
        $this->getEntityManager()->persist($entity);
    }

    public function commit(): void
    {
        $this->getEntityManager()->flush();
    }

    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllSortedByLastId(int $lastPk, int $limit)
    {
        $query = $this->_em
            ->createQuery('SELECT p FROM ' . Post::class . ' p WHERE p.id > :lastPk ORDER BY p.id ASC')
            ->setParameter('lastPk', $lastPk)
            ->setMaxResults($limit);

        return $query->getResult();
    }

    public function findAllSortedByFirstId(int $firstPk, int $limit)
    {
        $query = $this->_em
            ->createQuery('SELECT p FROM ' . Post::class . ' p WHERE p.id < :firstPk ORDER BY p.id DESC')
            ->setParameter('firstPk', $firstPk)
            ->setMaxResults($limit);

        return $query->getResult();
    }

    public function findAllSortedByIdDesc(int $limit)
    {
        $query = $this->_em
            ->createQuery('SELECT p FROM ' . Post::class . ' p ORDER BY p.id DESC')
            ->setMaxResults($limit);

        return $query->getResult();
    }

    /**
     * @param string[]
     * @return string[]
     */
    public function findPostIdsByOriginalIds(array $ids): array
    {
        $transform = function($item) {
            return $item['original_id'];
        };

        $result = array_map($transform, (array)$this->_em
            ->createQuery('SELECT p.original_id FROM ' . Post::class . ' p WHERE p.original_id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getScalarResult()
        );

        return $result;
    }

    public function findByOriginalId(string $originalId): Post
    {
        $post = $this->findOneBy([
            "original_id" => $originalId
        ]);

        if(null === $post) {
            throw new PostNotFoundException();
        }

        return $post;
    }
}
