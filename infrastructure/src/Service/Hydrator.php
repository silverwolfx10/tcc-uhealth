<?php 
namespace Infrastructure\Service;

use Zend\Stdlib\Hydrator\ClassMethods as ZendHydrator;
use Infrastructure\Interfaces\Hydrator as HydratorInterface;
/**
 * Para não depender diretamente de uma lib de terceiros
 **/
class Hydrator extends ZendHydrator implements HydratorInterface{

} 