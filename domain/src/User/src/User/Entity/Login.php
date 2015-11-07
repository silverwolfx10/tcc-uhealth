<?php
namespace Domain\User\Entity;

use \Domain\Base\Interfaces\Entity as EntityInterface;
use Infrastructure\Service\Hydrator;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity @ORM\Table(name="UserLogin")
 * @ORM\HasLifecycleCallbacks
 */
class Login implements EntityInterface
{
    /**
     * @var int
     * @ORM\Id @ORM\Column(name="id", type="integer") @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Domain\User\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $userId;

     /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @var string
     *
     * @ORM\Column(name="access", type="string", length=255, nullable=true)
     */
    private $access;

    /**
     * @var string
     * values= 'create', 'login'
     * @ORM\Column(name="type", type="string")
     */
    private $type;

    /**
     * @var string
     * values= 'waiting', 'active', 'expired'
     * @ORM\Column(name="status", type="string")
     */
    private $status;

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
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        if(! ($userId instanceof \Domain\User\Entity\User)) {
            throw new \InvalidArgumentException("Invalid value for userId, must be an instance of Domain\User\Entity\User");
        }

        $this->userId = $userId;
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
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * @param string $access
     */
    public function setAccess($access)
    {
        $this->access = $access;
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

        if(!in_array($status, ['waiting', 'active', 'expired'])) {
            throw new \InvalidArgumentException("Status is not in array, must be active or expired");
        }

        $this->status = $status;
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
        if(!$type) {
            throw new \InvalidArgumentException("Invalid value for Type");
        }

        if(!in_array($type, ['create', 'login'])) {
            throw new \InvalidArgumentException("Type is not in array, must be create or login");
        }

        $this->type = $type;
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
     * @ORM\PrePersist
     */
    public function setCreatedAt() {
        $this->createdAt = new \DateTime("now");
        return $this;
    }

    public function toArray() {
        $data = (new Hydrator(false))->extract($this);

        $data['userId'] = $data['userId']->toArrayApi();

        return $data;
    }

}
