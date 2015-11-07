<?php
namespace Domain\QuestionAndAnswer\Entity;
/**
 * Class UnitTest
 */
class QuestionAndAnswerTest extends \Infrastructure\Test\UnitTestCase
{
	//chamado automaticamente pelo phpunit
    public function setUp(\Phalcon\DiInterface $di = NULL, \Phalcon\Config $config = NULL) {
        $this->classTested = '\Domain\QuestionAndAnswer\Entity\QuestionAndAnswer';
        parent::setUp($di);
    }

    //verifica se classe existe
    public function testClassExists()
    {
        $this->assertTrue(class_exists($this->classTested), 'Entidade QuestionAndAnswer nao existe');
    }

    //insert feliz
    public function dataProviderValidAttributes(){
        return array(
            ['id', 1],
            ['adId', (new \Domain\Ad\Entity\Ad())],
            ['userId', (new \Domain\User\Entity\User())],
            ['questionId', (new \Domain\QuestionAndAnswer\Entity\QuestionAndAnswer())],
            ['comment', 'Atende nos finais de semana ?'],
        );
    }

    /**
     * @dataProvider dataProviderValidAttributes
     */
    public function testVerifyGettersAndSetters($field, $value){
        $entity = new $this->classTested();

        $set = 'set' . ucfirst($field);
        $get = 'get' . ucfirst($field);

        $entity->$set($value);

        $this->assertEquals($entity->$get(), $value);

    }
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for AdId, must be an instance of Domain\Ad\Entity\Ad
     */
    public function testVerifyAdIdWrong(){
        $entity = new $this->classTested();
        $entity->setAdId(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for userId, must be an instance of Domain\User\Entity\User
     */
    public function testVerifyUserIdWrong(){
        $entity = new $this->classTested();
        $entity->setUserId(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for QuestionId, must be an instance of Domain\QuestionAndAnswer\Entity\QuestionAndAnswer
     */
    public function testVerifyQuestionIdWrong(){
        $entity = new $this->classTested();
        $entity->setQuestionId(" ");
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value for comment
     */
    public function testVerifyCommentWrong(){
        $entity = new $this->classTested();
        $entity->setComment(" ");
    }

    public function testVerifyHydrator(){
        $data = [
            'comment' => 'Você atende nos finais de semana ?'
        ];

        $entity = new $this->classTested($data);
        $this->assertEquals($entity->getComment(), $data['comment']);
    }

    public function testVerifyToArray(){

        $entity = new $this->classTested();
        $entity->setComment('Você atende nos finais de semana ?');
        $data = $entity->toArray();
        $this->assertTrue(is_array($data));
        $this->assertEquals($entity->getComment(), $data['comment']);

    }
}