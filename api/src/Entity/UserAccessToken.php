<?php

namespace App\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="user_access_tokens",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="token_idx", columns={"access_token"})}
 * )
 */
class UserAccessToken
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tokens")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $user;

    /**
     * Тут мы будем хранить наш токен. Токен необходимо генерировать самому и как можно сложнее и длиннее, чтобы
     * исключить возможность подбора
     *
     * @var string
     * @ORM\Column(name="access_token", type="string")
     */
    protected $accessToken;

    /**
     * Дата, после которой токен будет считаться не активным
     *
     * @var \DateTime
     * @ORM\Column(name="expired_at", type="datetime")
     */
    protected $expiredAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return UserAccessToken
     */
    public function setUser(User $user): UserAccessToken
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     * @return UserAccessToken
     */
    public function setAccessToken(string $accessToken): UserAccessToken
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpiredAt(): \DateTime
    {
        return $this->expiredAt;
    }

    /**
     * @param \DateTime $expiredAt
     * @return UserAccessToken
     */
    public function setExpiredAt(\DateTime $expiredAt): UserAccessToken
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return UserAccessToken
     */
    public function setCreatedAt(\DateTime $createdAt): UserAccessToken
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
