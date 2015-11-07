<?php
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

class DataFixturesTask extends \Phalcon\CLI\Task
{
    private $dataFixtures;
    public function initialize(){
        $infraConfig = $this->di->get('Infrastructure\Config');

        $this->dataFixtures = $infraConfig['fixtures'];
    }
    public function mainAction() {
         echo "\n DataFixtures \n";
    }

    /**
    * @param array $params
    */
   public function importAction() {
       echo "\n Importing... \n";
       $loader = new Loader();

       foreach($this->dataFixtures as $path) {
           $loader->loadFromDirectory($path);
       }

       $purger = new ORMPurger();
       $executor = new ORMExecutor($this->di->get('entityManager'), $purger);
       $executor->execute($loader->getFixtures(), true);

       echo "\n Done \n";
   }

    /**
     * @param array $params
     */
    public function resetAction() {
        echo "\n Clean and Importing... \n";
        $loader = new Loader();

        foreach($this->dataFixtures as $path) {
            $loader->loadFromDirectory($path);
        }

        $purger = new ORMPurger();
        $executor = new ORMExecutor($this->di->get('entityManager'), $purger);
        $executor->execute($loader->getFixtures());

        echo "\n Done \n";
    }
}
