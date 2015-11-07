<?php

namespace Api\Controllers;


class AdController extends RESTController
{

//    public function get()
//    {
//        $this->response->setStatusCode(401, 'Unauthorized')->sendHeaders();
//        return ['messages' => ['Opção inválida']];
//    }

    public function registerInformation()
    {
        $data = [];
        $data['uf'] = $this->di->get('entityManager')->getRepository('Domain\Address\Entity\State')->findAll();
        $data['skill'] = $this->di->get('entityManager')->getRepository('Domain\Ad\Entity\Skill')->findAll();

        return [
            'data' => $data,
            'messages' => null,
            'status' => true
        ];
    }

    public function get($id){

        return ['data' => $this->di->get('entityManager')->getRepository('Domain\Ad\Entity\Ad')->findOneById($id)->toArrayApi()];

    }

    public function getByMyUri($myUri){

        return ['status' => true, 'data' => $this->di->get('entityManager')->getRepository('Domain\Ad\Entity\Ad')->fetchMyUri($myUri)->toArrayApi()];

    }

    public function getByUserId($userId){

        return ['data' => $this->di->get('entityManager')->getRepository('Domain\Ad\Entity\Ad')->findOneByPersonalId($userId)->toArrayApi()];

    }


    public function put(){

        $registerService = $this->di->get('Application\Ad\Service\Ad');

        return $registerService('edit')->update($this->request->getPut());
    }

    public function location($lat, $lng, $distance){

        return [
            'data' => $this->di->get('entityManager')->getRepository('Domain\Ad\Entity\Address')->searchMathAlgoritm($lat, $lng, $distance),
            'status' => true
        ];

    }

    public function searchByAddress($address){

        $geographicCoordenatesService = $this->di->get('Application\Address\Service\GeographicCoordenates');
        $return = $geographicCoordenatesService->searchByAddress($address)['data'];
        $return['results'] = $this->di->get('entityManager')->getRepository('Domain\Ad\Entity\Address')->searchMathAlgoritm($return['coordenates']['lat'], $return['coordenates']['lng'], 20);


        return [
            'data' => $return,
            'status' => true
        ];
    }

}
