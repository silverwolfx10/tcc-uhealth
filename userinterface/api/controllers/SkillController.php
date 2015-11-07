<?php

namespace Api\Controllers;


class SkillController extends RESTController
{

    public function get()
    {
        $repository = $this->di->get('entityManager')->getRepository('Domain\Ad\Entity\Skill');

        $data = $repository->findAll();
        return [
            'data' => $data,
            'messages' => null,
            'status' => true
        ];
    }
}
