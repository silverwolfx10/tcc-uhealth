<?php
namespace Domain\User\Entity;

use \Domain\Base\Interfaces\Entity as EntityInterface;
use Infrastructure\Service\Hydrator;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="UserUser")
 * @ORM\HasLifecycleCallbacks
 */
class User implements EntityInterface
{
    /**
     * @var int
     * @ORM\Id @ORM\Column(name="id", type="integer") @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="image", type="string", length=200, nullable=true)
     */
    private $image;

    /**
     * @var string
     * @ORM\Column(name="image_thumb", type="string", length=400, nullable=true)
     */
    private $imageThumb;

    /**
     * @var string
     * @ORM\Column(name="image_path", type="string", length=400, nullable=true)
     */
    private $imagePath;



    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="my_uri", type="string", length=100, nullable=false)
     */
    private $myUri;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="moip", type="string", length=100, nullable=true)
     */
    private $moip;

    /**
     * @var string
     * @ORM\Column(name="cpf", type="string", length=11, nullable=true)
     */
    private $cpf;

    /**
     * @var string
     * @ORM\Column(name="cref", type="string", length=12, nullable=true)
     */
    private $cref;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(name="facebook_id", type="string", nullable=true)
     */
    private $facebookId;

    /**
     * @var string
     * @ORM\Column(name="twitter_id", type="string", nullable=true)
     */
    private $twitterId;

    /**
     * @var string
     * @ORM\Column(name="linkedin_id", type="string", nullable=true)
     */
    private $linkedinId;

    /**
     * @var string
     * values= 'user', 'personal'
     * @ORM\Column(name="type", type="string")
     */
    private $type;

    /**
     * @var string
     * values= 'active', 'inactive', 'blocked'
     * @ORM\Column(name="status", type="string")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     */
    private $token;

     /**
     * @var \Date
     *
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="chave_recuperacao", type="string", length=255, nullable=true)
     */
    private $chaveRecuperacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    public function __construct(array $options = []) {
        $this->type = 'user';
        $this->status = 'active';

        (new Hydrator)->hydrate($options, $this);
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageThumb()
    {
        return $this->imageThumb;
    }

    /**
     * @param string $imageThumb
     */
    public function setImageThumb($imageThumb)
    {
        $this->imageThumb = $imageThumb;
        return $this;
    }

    /**
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @param string $imagePath
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $name = trim($name);
        if(!$name){
            throw new \InvalidArgumentException("Invalid value for Name");
        }

        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getMyUri()
    {
        return $this->myUri;
    }

    /**
     * @param string $myUri
     */
    public function setMyUri($myUri = null)
    {
        $myUri = trim($myUri);
        if(!$myUri){
            throw new \InvalidArgumentException("Invalid value for MyUri");
        }

        $this->myUri = $myUri;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $email = trim($email);
        if(!$email){
            throw new \InvalidArgumentException("Invalid value for Email");
        }

        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getMoip()
    {
        return $this->moip;
    }

    /**
     * @param string $moip
     */
    public function setMoip($moip)
    {
        $moip = trim($moip);
        if(!$moip){
            $moip = '@';
//            throw new \InvalidArgumentException("Invalid value for Moip");
        }

        $this->moip = $moip;
        return $this;
    }

    /**
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
        return $this;
    }

    /**
     * @return string
     */
    public function getCref()
    {
        return $this->cref;
    }

    /**
     * @param string $cref
     */
    public function setCref($cref)
    {
        $this->cref = $cref;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param string $facebookId
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTwitterId()
    {
        return $this->twitterId;
    }

    /**
     * @param string $TwitterId
     */
    public function setTwitterId($twitterId)
    {
        $this->twitterId = $twitterId;
        return $this;
    }

    /**
     * @return string
     */
    public function getLinkedinId()
    {
        return $this->linkedinId;
    }

    /**
     * @param string $linkedinId
     */
    public function setLinkedinId($linkedinId)
    {
        $this->linkedinId = $linkedinId;
        return $this;
    }

     /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $type = trim($type);
        if(!$type){
            throw new \InvalidArgumentException("Invalid value for Type");
        }

        if(!in_array($type, ['user', 'personal'])) {
            throw new \InvalidArgumentException("Type is not in array, must be user or personal");
        }

        $this->type = $type;
        return $this;
    }


    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $status = trim($status);
        if(!$status) {
            throw new \InvalidArgumentException("Invalid value for Status");
        }

        if(!in_array($status, ['active', 'inactive', 'blocked'])) {
            throw new \InvalidArgumentException("Status is not in array, must be active, inactive or blocked");
        }

        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        $this->setSalt();

        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt = null)
    {
        if(is_null($this->salt)){
            $this->salt =  substr(uniqid(mt_rand(), true),0, 100);
        }

        if(!is_null($salt)){
            $this->salt = $salt;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getChaveRecuperacao()
    {
        return $this->chaveRecuperacao;
    }

    /**
     * @param string $chaveRecuperacao
     */
    public function setChaveRecuperacao($chaveRecuperacao)
    {
        $this->chaveRecuperacao = $chaveRecuperacao;
        return $this;
    }

   /**
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param \DateTime $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function setUpdatedAt() {
        $this->updatedAt = new \DateTime("now");
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *@ORM\PrePersist
     */
    public function setCreatedAt() {
        if(is_null($this->createdAt)) {
            $this->createdAt = new \DateTime("now");
        }
        return $this;
    }

    public function toArray() {
        return (new Hydrator(false))->extract($this);
    }

    public function toArrayApi() {
        $data = (new Hydrator(false))->extract($this);
        unset($data['password']);
        unset($data['salt']);
        unset($data['token']);
        unset($data['chaveRecuperacao']);

        return $data;
    }

}
