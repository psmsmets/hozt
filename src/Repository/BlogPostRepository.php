<?php

namespace App\Repository;

use App\Entity\BlogPost;
use App\Entity\BlogCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BlogPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogPost[]    findAll()
 * @method BlogPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogPost::class);
    }

    // /**
    //  * @return BlogPost[] Returns an array of BlogPost objects
    //  */
    public function findSpecialPinnedBlogPost()
    {
        $now = new \DateTime('now');

        return $this->createQueryBuilder('post')
            ->innerJoin('post.category','category')
            ->leftJoin('post.event','event')
            ->leftJoin('event.competition','competition')
            ->addSelect('post')
            ->addSelect('category')
            ->addSelect('event')
            ->addSelect('competition')
            ->andWhere('post.enabled = :enabled')
            ->andWhere('post.pinned = :pinned')
            ->andWhere('post.special = :special')
            ->andWhere('post.publishAt <= :now')
            //->andWhere('(post.publishUntil > :now or post.publishUntil is null)')
            ->setParameter('enabled', true)
            ->setParameter('pinned', true)
            ->setParameter('special', true)
            ->setParameter('now', $now)
            ->orderBy('post.publishAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findSpecialBlogPosts(int $limit)
    {
        $now = new \DateTime('now');

        return $this->createQueryBuilder('post')
            ->innerJoin('post.category','cat')
            ->leftJoin('post.event','event')
            ->leftJoin('event.competition','competition')
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
            ->setParameter('now', $now)
            ->orderBy('post.publishAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBlogPosts(BlogCategory $category = null, int $page = 1,
        bool $admin = false, int $limit = BlogPost::NUMBER_OF_ITEMS)
    {
        $now = new \DateTime('now');
        $offset = ( $page < 1 ? 0 : $page - 1 ) * BlogPost::NUMBER_OF_ITEMS;

        if (is_null($category))
        {
            return $this->createQueryBuilder('post')
                ->innerJoin('post.category','cat')
                ->leftJoin('post.event','event')
                ->leftJoin('event.competition','competition')
                ->addSelect('post')
                ->addSelect('cat')
                ->addSelect('event')
                ->addSelect('competition')
                ->andWhere('post.enabled = :enabled')
                ->andWhere('post.publishAt <= :now')
                //->andWhere('(p.publishUntil > :now or p.publishUntil is null)')
                ->setParameter('enabled', true)
                ->setParameter('now', $now)
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
                ->addSelect('post')
                ->addSelect('cat')
                ->addSelect('event')
                ->addSelect('competition')
                ->andWhere('post.category = :category')
                ->andWhere('post.enabled = :enabled')
                ->andWhere('post.publishAt <= :now')
                //->andWhere('(p.publishUntil > :now or p.publishUntil is null)')
                ->setParameter('category', $category)
                ->setParameter('enabled', true)
                ->setParameter('now', $now)
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
        $now = new \DateTime('now');

        if (is_null($category))
        {
            return $this->createQueryBuilder('post')
                ->select('count(post.id)')
                ->innerJoin('post.category','cat')
                ->andWhere('post.enabled = :enabled')
                ->andWhere('post.publishAt <= :now')
                //->andWhere('(p.publishUntil > :now or p.publishUntil is null)')
                ->setParameter('enabled', true)
                ->setParameter('now', $now)
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
                ->setParameter('now', $now)
                ->getQuery()
                ->getSingleScalarResult()
            ;
        }
    }

    public function getBlogPostPages(string $category = null)
    {
        return (int) ceil( $this->countBlogPosts($category) / BlogPost::NUMBER_OF_ITEMS );
    }

    public function findBlogPost(int $id, bool $admin = false)
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
            //->andWhere('(post.enabled = :enabled and post.publishAt <= :now) or post.publishAt >= :now')
            ->setParameter('id', $id)
            //->setParameter('enabled', true)
            //->setParameter('now', date("Y-m-d H:i"))
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
        $now = new \DateTime('now');

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
            ->setParameter('now', $now)
            ->orderBy('post.publishAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

}
