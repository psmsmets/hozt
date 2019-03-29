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
        return $this->createQueryBuilder('post')
            ->innerJoin('post.category','cat')
            ->leftJoin('post.event','event')
            ->leftJoin('event.competition','competition')
            ->leftJoin('competition.documents','docs')
            ->addSelect('post')
            ->addSelect('cat')
            ->addSelect('event')
            ->addSelect('competition')
            ->andWhere('post.enabled = :enabled')
            ->andWhere('post.pinned = :pinned')
            ->andWhere('post.special = :special')
            ->andWhere('post.publishAt <= :now')
            //->andWhere('(p.publishUntil > :now or p.publishUntil is null)')
            ->setParameter('enabled', true)
            ->setParameter('pinned', false)
            ->setParameter('special', true)
            ->setParameter('now', date("Y-m-d H:i"))
            ->orderBy('post.publishAt', 'DESC')
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
            return $this->createQueryBuilder('post')
                ->innerJoin('post.category','cat')
                ->leftJoin('post.event','event')
                ->leftJoin('event.competition','competition')
                ->leftJoin('competition.documents','docs')
                ->addSelect('post')
                ->addSelect('cat')
                ->addSelect('event')
                ->addSelect('competition')
                ->addSelect('docs')
                ->andWhere('post.enabled = :enabled')
                ->andWhere('post.publishAt <= :now')
                //->andWhere('(p.publishUntil > :now or p.publishUntil is null)')
                ->setParameter('enabled', true)
                ->setParameter('now', date("Y-m-d H:i"))
                ->orderBy('post.publishAt', 'DESC')
                ->setFirstResult( $offset )
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult()
            ;
        } else {
            return $this->createQueryBuilder('post')
                ->innerJoin('post.category','cat')
                ->leftJoin('post.event','event')
                ->leftJoin('event.competition','competition')
                ->leftJoin('competition.documents','docs')
                ->addSelect('post')
                ->addSelect('cat')
                ->addSelect('event')
                ->addSelect('competition')
                ->addSelect('docs')
                ->andWhere('cat.slug = :category')
                ->andWhere('post.enabled = :enabled')
                ->andWhere('post.publishAt <= :now')
                //->andWhere('(p.publishUntil > :now or p.publishUntil is null)')
                ->setParameter('category', $category)
                ->setParameter('enabled', true)
                ->setParameter('now', date("Y-m-d H:i"))
                ->orderBy('post.publishAt', 'DESC')
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
            return $this->createQueryBuilder('post')
                ->select('count(post.id)')
                ->innerJoin('post.category','cat')
                ->andWhere('post.enabled = :enabled')
                ->andWhere('post.publishAt <= :now')
                //->andWhere('(p.publishUntil > :now or p.publishUntil is null)')
                ->setParameter('enabled', true)
                ->setParameter('now', date("Y-m-d H:i"))
                ->getQuery()
                ->getSingleScalarResult()
            ;
        } else {
            return $this->createQueryBuilder('post')
                ->select('count(post.id)')
                ->innerJoin('post.category','cat')
                ->andWhere('cat.slug = :category')
                ->andWhere('post.enabled = :enabled')
                ->andWhere('post.publishAt <= :now')
                //->andWhere('(p.publishUntil > :now or p.publishUntil is null)')
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
        return $this->createQueryBuilder('post')
            ->innerJoin('post.category','category')
            ->leftJoin('post.event','event')
            ->leftJoin('event.competition','competition')
            ->leftJoin('competition.documents','docs')
            ->addSelect('post')
            ->addSelect('category')
            ->addSelect('event')
            ->addSelect('competition')
            ->addSelect('docs')
            ->andWhere('post.enabled = :enabled')
            ->andWhere('post.pinned = :pinned')
            ->andWhere('post.special = :special')
            ->andWhere('post.publishAt <= :now')
            //->andWhere('(post.publishUntil > :now or post.publishUntil is null)')
            ->setParameter('enabled', true)
            ->setParameter('pinned', true)
            ->setParameter('special', true)
            ->setParameter('now', date("Y-m-d H:i"))
            ->orderBy('post.publishAt', 'DESC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function findBlogPost(int $id)
    {
        return $this->createQueryBuilder('post')
            ->innerJoin('post.category','category')
            ->leftJoin('post.event','event')
            ->leftJoin('event.competition','competition')
            ->leftJoin('competition.documents','docs')
            ->addSelect('post')
            ->addSelect('category')
            ->addSelect('event')
            ->addSelect('competition')
            ->addSelect('docs')
            ->andWhere('post.id = :id')
            ->andWhere('post.enabled = :enabled')
            ->andWhere('post.publishAt <= :now')
            //->andWhere('(post.publishUntil > :now or post.publishUntil is null)')
            ->setParameter('id', $id)
            ->setParameter('enabled', true)
            ->setParameter('now', date("Y-m-d H:i"))
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function findPinnedBlogPosts(int $current=null)
    {
        $posts = $this->createQueryBuilder('post')
            ->andWhere('post.pinned = :pinned')
            ->setParameter('pinned', true);
        if (!is_null($current)) {
            $posts->andWhere('post.id != :id')
            ->setParameter('id', $current);
        }
        return $posts->getQuery()->getResult();
    }
    public function findCalenderEventBlogPosts(string $uuid)
    {
        return $this->createQueryBuilder('post')
            ->innerJoin('post.category','category')
            ->leftJoin('post.event','event')
            ->addSelect('post')
            ->addSelect('category')
            ->addSelect('event')
            ->andWhere('event.uuid = :uuid')
            ->andWhere('post.enabled = :enabled')
            ->andWhere('post.publishAt <= :now')
            //->andWhere('(post.publishUntil > :now or post.publishUntil is null)')
            ->setParameter('uuid', $uuid)
            ->setParameter('enabled', true)
            ->setParameter('now', date("Y-m-d H:i"))
            ->orderBy('post.publishAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

}
