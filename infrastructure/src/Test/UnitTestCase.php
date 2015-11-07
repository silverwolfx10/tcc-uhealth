<?php
namespace Infrastructure\Test;
use Phalcon\DI;
use Phalcon\DiInterface;
use Phalcon\Config;
use \Phalcon\Test\UnitTestCase as PhalconTestCase;

abstract class UnitTestCase extends PhalconTestCase
{
    protected $classTested;
    /**
     * @var \Voice\Cache
     */
    protected $_cache;
    /**
     * @var \Phalcon\Config
     */
    protected $_config;
    public function setUp(DiInterface $di = NULL, Config $config = NULL
    ) {
        parent::setUp(DI::getDefault());
    }

    public function tearDown(){

    }
    
    protected function instantiateClass($type = null)
    {
        $class = $this->classTested;
        return $class::start($type);
    }
    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }
    /**
     *  Facilitador para testar setter automatico
     *  @author Leandro Menezes
     **/
    public function automateSetter($class, $field, $value){
        if(!($class InstanceOf $this->classTested)){
            throw new \Exception("Classe dever ser uma intancia de ". $this->classTested);
        }
        $set = 'set' . ucfirst($field);
        return $class->{$set}($value);
    }
    /**
     *  Facilitador para testar getter automatico
     *  @author Leandro Menezes
     **/
    public function automateGetter($class, $field){
        if(!($class InstanceOf $this->classTested)){
            throw new \Exception("Classe dever ser uma intancia de ". $this->classTested);
        }
        $get = 'get' . ucfirst($field);
        return $class->{$get}();
    }
}