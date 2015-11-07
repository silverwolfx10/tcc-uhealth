<?php

namespace Api\Controllers;


class AddressController extends RESTController
{

    public function get()
    {
        $this->response->setStatusCode(401, 'Unauthorized')->sendHeaders();
        return ['messages' => ['Opção inválida']];
    }

    public function uf()
    {
        $repository = $this->di->get('entityManager')->getRepository('Domain\Address\Entity\State');

        $data = $repository->findAll();
        return [
            'data' => $data,
            'messages' => null,
            'status' => true
        ];
    }

    public function city($uf)
    {
        $repository = $this->di->get('entityManager')->getRepository('Domain\Address\Entity\City');

        $data = $repository->findBy(['state' => $uf]);
        return [
            'data' => $data,
            'messages' => null,
            'status' => true
        ];
    }

    public function hood($city_id)
    {
        $repository = $this->di->get('entityManager')->getRepository('Domain\Address\Entity\Hood');

        $data = $repository->findBy(['cityId' => $city_id]);
        return [
            'data' => $data,
            'messages' => null,
            'status' => true
        ];
    }

    public function street($hood_id)
    {
        $repository = $this->di->get('entityManager')->getRepository('Domain\Address\Entity\Street');

        $data = $repository->findBy(['hoodId' => $hood_id]);
        return [
            'data' => $data,
            'messages' => null,
            'status' => true
        ];
    }

    public function zipcode($zip_code)
    {

        $return  = [
            'data' => null,
            'messages' => null,
            'status' => false
        ];
        $service = $this->di->get('Application\Address\Service\Address');

        $geographicCoordenatesService = $this->di->get('Application\Address\Service\GeographicCoordenates');
        $geographicCoordenatesService->searchByZipCodeAndNumber($zip_code, false);

        $data = $service->searchByZipCode($zip_code);

        if($data){


            $states = $this->di->get('entityManager')->getRepository('Domain\Address\Entity\State')->findAll();
            $cities = $this->di->get('entityManager')->getRepository('Domain\Address\Entity\City')->fetchMinimalByState($data['city']->getState());


            $return['data'] = [
                'cep' => $data,
                'states' => $states,
                'cities' => $cities
            ];

            $return['status'] = true;

            return $return;
        }

        $return['messages'] = ['Não encontramos nenhuma rua com esse CEP'];
        return $return;
    }

    public function geographicByZipCode($zip_code, $number=false){

        $geographicCoordenatesService = $this->di->get('Application\Address\Service\GeographicCoordenates');

        return $geographicCoordenatesService->searchByZipCodeAndNumber($zip_code, $number);
    }


    public function geographicByPost(){
        $data = $this->request->getPost();
        $geographicCoordenatesService = $this->di->get('Application\Address\Service\GeographicCoordenates');
        return $geographicCoordenatesService->resolve($data['uf'], $data['city'], $data['hood'], $data['street'], $data['number']);
    }



}
