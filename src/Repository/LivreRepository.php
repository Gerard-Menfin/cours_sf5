<?php

namespace App\Repository;

use App\Entity\Livre;
use App\Entity\Categorie;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Livre>
 *
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    public function add(Livre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Livre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Livre[] Returns an array of Livre objects
    * Doctrine Query Language
    *    SELECT l.*
    *    FROM livre l
    *    WHERE l.titre LIKE '%le%'
    *    ORDER BY l.titre;
    */
   public function recherche($motRecherche): array
   {
       return $this->createQueryBuilder('l')
           ->where('l.titre LIKE :val')
           ->setParameter('val', '%' . $motRecherche . '%')
           ->orderBy('l.titre', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

   /**
    *   SELECT l.*
    *   FROM livre l 
    *       JOIN livre_categorie lc ON l.id = lc.livre_id
    *       JOIN categorie c ON c.id = lc.categorie_id
    *   WHERE c.mots_cles LIKE "%science%" OR c.libelle LIKE "%science%";
    */
   public function rechercheCategories($motRecherche)
   {
        return $this->createQueryBuilder('l')
                    ->join("l.categories", "c")
                    ->where("c.mots_cles LIKE :mot OR c.libelle LIKE :mot")
                    ->setParameter("mot", "%$motRecherche%")
                    ->orderBy("c.libelle")
                    ->addOrderBy("l.titre")
                    ->getQuery()->getResult();
   }

//    public function findOneBySomeField($value): ?Livre
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
