<?php

namespace Infrastructure\Domain\Ad\Repository;

use \Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class AddressRepository extends EntityRepository {

//retorna todos os personais em em um radio de uma determinada distância
    public function searchMathAlgoritm($lat, $lng, $distance = 30) {

        $sql = 'SELECT ad.id, a.ad_id as adId, a.id, a.lat, a.lng, u.my_uri, u.name, u.image_path, u.image_thumb, a.hood_name, a.city_name,
        ( 6378 * acos( cos( radians(:lat) ) * cos( radians( a.lat ) ) *
        cos( radians( a.lng ) - radians(:lng) ) + sin( radians(:lat) ) *
        sin( radians( a.lat ) ) ) ) AS distance
        FROM AdAddress a
        INNER JOIN AdAd ad ON ad.id = a.ad_id
        INNER JOIN UserUser u ON u.id = ad.personal_id
        GROUP BY a.id HAVING distance <= :distance
        ORDER BY distance';

        $stmt = $this->_em->getConnection()->prepare($sql);

        $stmt->execute([
            'lat'   => $lat,
            'lng'   => $lng,
            'distance' => $distance

        ]);
        return $stmt->fetchAll();

//
    }

    public function searchByIdIn($in){
        $adsIn = explode(",", $in);

        //todas alocacoes do usuario
        $entities = $this->createQueryBuilder('a')
            ->select("a.lat, a.lng, u.id as userId, u.imagePath, u.imageThumb, u.myUri, 10 as teste")
            ->innerJoin('Domain\Ad\Entity\Ad', 'ad', 'WITH', 'ad.id = a.adId')
            ->innerJoin('Domain\User\Entity\User', 'u', 'WITH', 'ad.personalId = u.id')
            ->where('a.id IN (:adsIn)' )
//            ->Andwhere("a.updatedAt IS NULL ")
//            ->Andwhere("u.status = 1")
//            ->AndWhere("l.inactivatedAt >= '{$date->format('Y-m-01')}' OR l.inactivatedAt IS NULL")
            ->setParameter('adsIn', $adsIn)
            ->getQuery()
            ->getResult();

//        var_dump($adsIn);
        var_dump($entities);
        die;
    }
}
