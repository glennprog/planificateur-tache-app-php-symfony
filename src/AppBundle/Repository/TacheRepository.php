<?php

namespace AppBundle\Repository;

/**
 * TacheRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TacheRepository extends \Doctrine\ORM\EntityRepository
{
    public function consulterTacheDescription($criteria)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT t.id, t.guid, t.nom, t.statut, t.date_creation, t.description, t.ordre, t.est_archivee FROM AppBundle:Tache\Tache t WHERE t.id = :id ');
        $query->setParameter('id', $criteria['id']);
        $tache = $query->getResult();
        if(count($tache) == 0)
        {
            return null;
        }
        else
        {
            return $tache[0]; 
        }
    }

    public function consulterTacheObjectif($criteria)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT t.id, t.guid, t.nom, t.statut, t.date_creation, t.objectif, t.ordre, t.est_archivee FROM AppBundle:Tache\Tache t WHERE t.id = :id ');
        $query->setParameter('id', $criteria['id']);
        $tache = $query->getResult();
        if(count($tache) == 0)
        {
            return null;
        }
        else
        {
            return $tache[0]; 
        }
    }

    public function consulterTacheRemarque($criteria)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT t.id, t.guid, t.nom, t.statut, t.date_creation, t.remarque, t.ordre, t.est_archivee FROM AppBundle:Tache\Tache t WHERE t.id = :id ');
        $query->setParameter('id', $criteria['id']);
        $tache = $query->getResult();
        if(count($tache) == 0)
        {
            return null;
        }
        else
        {
            return $tache[0]; 
        }
    }

    public function monitoring_liste_taches_total()
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('SELECT COUNT(t) FROM AppBundle:Tache\Tache t WHERE t.est_archivee = :archivee ');
        $query->setParameter('archivee', 1);
        $taches_archivees_total = $query->getSingleScalarResult();

        $query = $em->createQuery('SELECT COUNT(t) FROM AppBundle:Tache\Tache t WHERE t.est_archivee = :non_archivee ');
        $query->setParameter('non_archivee', 0);
        $taches_non_archivees_total = $query->getSingleScalarResult();

        $taches_total = $this->createQueryBuilder('t')
        ->select('COUNT(t)')
        ->getQuery()
        ->getSingleScalarResult();

        $monitoring_liste_taches_total = array(
            'taches_archivees_total' => $taches_archivees_total,
            'taches_non_archivees_total' => $taches_non_archivees_total,
            'taches_total' => $taches_total
        );
        
        return $monitoring_liste_taches_total;
    }
}
