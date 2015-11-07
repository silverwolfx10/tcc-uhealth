<?php 
namespace Infrastructure\Service;

use Doctrine\Common\Collections\ArrayCollection as DoctrineArrayCollection;
use Infrastructure\Interfaces\Collection as CollectionInterface;
/**
 * Para não depender diretamente de uma lib de terceiros
 **/
class ArrayCollection extends DoctrineArrayCollection implements CollectionInterface{


} 