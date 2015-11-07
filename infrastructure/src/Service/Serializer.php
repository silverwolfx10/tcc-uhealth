<?php 
namespace Infrastructure\Service;

use \Infrastructure\Interfaces\Serializer as SerializerInterface;

/**
 * Para não depender diretamente de uma lib de terceiros
 **/
class Serializer implements SerializerInterface{

    private $serializer;

    public function __construct() {
        $this->serializer = \JMS\Serializer\SerializerBuilder::create()->build();
    }

    public function serialize(array $data = [], $format = 'json'){
        $context = new \JMS\Serializer\SerializationContext();
        $context->setSerializeNull(true);

        return $this->serializer->serialize($data, $format, $context);
    }
} 