<?php

namespace App\Repository;

use App\Entity\BlogPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BlogPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogPost[]    findAll()
 * @method BlogPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogPostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BlogPost::class);
    }

    // /**
    //  * @return BlogPost[] Returns an array of BlogPost objects
    //  */
    public function findSpecialBlogPosts(int $limit)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.enabled = :enabled')
            ->andWhere('p.pinned = :pinned')
            ->andWhere('p.special = :special')
            ->andWhere('p.publishAt <= :now')
            ->andWhere('(p.publishUntil > :now or p.publishUntil is null)')
            ->setParameter('enabled', true)
            ->setParameter('pinned', false)
            ->setParameter('special', true)
            ->setParameter('now', date("Y-m-d H:i"))
            ->orderBy('p.publishAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findBlogPosts(string $category = null, int $page = 1, int $limit = BlogPost::NUMBER_OF_ITEMS)
    {
        $offset = ( $page < 1 ? 0 : $page - 1 ) * BlogPost::NUMBER_OF_ITEMS;

        if (is_null($category))
        {
            return $this->createQueryBuilder('p')
                ->innerJoin('p.category','c')
                ->andWhere('p.enabled = :enabled')
                ->andWhere('c.enabled = :enabled')
                ->andWhere('p.publishAt <= :now')
                ->andWhere('(p.publishUntil > :now or p.publishUntil is null)')
                ->setParameter('enabled', true)
                ->setParameter('now', date("Y-m-d H:i"))
                ->orderBy('p.publishAt', 'DESC')
                ->setFirstResult( $offset )
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult()
            ;
        } else {
            return $this->createQueryBuilder('p')
                ->innerJoin('p.category','c')
                ->andWhere('c.slug = :category')
                ->andWhere('p.enabled = :enabled')
                ->andWhere('c.enabled = :enabled')
                ->andWhere('p.publishAt <= :now')
                ->andWhere('(p.publishUntil > :now or p.publishUntil is null)')
                ->setParameter('category', $category)
                ->setParameter('enabled', true)
                ->setParameter('now', date("Y-m-d H:i"))
                ->orderBy('p.publishAt', 'DESC')
                ->setFirstResult( $offset )
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult()
            ;
        }
    }
    public function countBlogPosts(string $category = null)
    {
        if (is_null($category))
        {
            return $this->createQueryBuilder('p')
                ->select('count(p.id)')
                ->innerJoin('p.category','c')
                ->andWhere('p.enabled = :enabled')
                ->andWhere('c.enabled = :enabled')
                ->andWhere('p.publishAt <= :now')
                ->andWhere('(p.publishUntil > :now or p.publishUntil is null)')
                ->setParameter('enabled', true)
                ->setParameter('now', date("Y-m-d H:i"))
                ->getQuery()
                ->getSingleScalarResult()
            ;
        } else {
            return $this->createQueryBuilder('p')
                ->select('count(p.id)')
                ->innerJoin('p.category','c')
                ->andWhere('c.slug = :category')
                ->andWhere('p.enabled = :enabled')
                ->andWhere('c.enabled = :enabled')
                ->andWhere('p.publishAt <= :now')
                ->andWhere('(p.publishUntil > :now or p.publishUntil is null)')
                ->setParameter('category', $category)
                ->setParameter('enabled', true)
                ->setParameter('now', date("Y-m-d H:i"))
                ->getQuery()
                ->getSingleScalarResult()
            ;
        }
    }
    public function getBlogPostPages(string $category = null)
    {
        return (int) ceil( $this->countBlogPosts($category) / BlogPost::NUMBER_OF_ITEMS );
    }
    public function findSpecialPinnedBlogPost()
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.category','c')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('p.enabled = :enabled')
            ->andWhere('p.pinned = :pinned')
            ->andWhere('p.special = :special')
            ->andWhere('p.publishAt <= :now')
            ->andWhere('(p.publishUntil > :now or p.publishUntil is null)')
            ->setParameter('enabled', true)
            ->setParameter('pinned', true)
            ->setParameter('special', true)
            ->setParameter('now', date("Y-m-d H:i"))
            ->orderBy('p.publishAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function findBlogPost(int $id)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :id')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('c.publishAt <= :now')
            ->andWhere('(c.publishUntil > :now or c.publishUntil is null)')
            ->setParameter('id', $id)
            ->setParameter('enabled', true)
            ->setParameter('now', date("Y-m-d H:i"))
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function findPinnedBlogPosts(int $current=null)
    {
        $posts = $this->createQueryBuilder('p')
            ->andWhere('p.pinned = :pinned')
            ->setParameter('pinned', true);
        if (!is_null($current)) {
            $posts->andWhere('p.id != :id')
            ->setParameter('id', $current);
        }
        return $posts->getQuery()->getResult();
    }
}
