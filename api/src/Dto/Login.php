<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class Login
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected $email;

    /**
     * @var string
     * @Assert\NotBlank()
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected $password;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Login
     */
    public function setEmail(string $email): Login
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Login
     */
    public function setPassword(string $password): Login
    {
        $this->password = $password;

        return $this;
    }
}
