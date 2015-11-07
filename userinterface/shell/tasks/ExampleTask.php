<?php

class ExampleTask extends \Phalcon\CLI\Task
{
    public function mainAction() {
         echo "\nExample action \n";
    }

    /**
    * @param array $params
    */
   public function testAction(array $params) {
       echo sprintf('hello %s', $params[0]) . PHP_EOL;
       echo sprintf('best regards, %s', $params[1]) . PHP_EOL;
   }
}
